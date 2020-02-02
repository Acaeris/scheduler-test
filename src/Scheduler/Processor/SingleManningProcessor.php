<?php

namespace Scheduler\Processor;

use Psr\Log\LoggerInterface;
use Scheduler\Entity\Interfaces\RotaInterface;
use Scheduler\Entity\Interfaces\ShiftInterface;
use Scheduler\Entity\SingleManning;
use Scheduler\Repository\ShiftRepository;

class SingleManningProcessor
{
    const SHIFT_START = 1;
    const SHIFT_END = 2;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var ShiftRepository Shift data repository */
    private $shiftRepository;

    /** @var array Start event of single manning */
    private $soloStart;

    /** @var SingleManning[] Single manning records */
    private $singleMannings;

    /** @var RotaInterface Currently processing Rota */
    private $rota;

    /** @var array Used for processing who's working at a given time */
    private $workingStaff;

    public function __construct(
        LoggerInterface $logger,
        ShiftRepository $shiftRepository
    ) {
        $this->logger = $logger;
        $this->shiftRepository = $shiftRepository;
    }

    private static function orderEventTimes(array $eventA, array $eventB): int
    {
        if ($eventA['time'] == $eventB['time']) {
            return 0;
        }

        return ($eventA['time'] < $eventB['time']) ? -1 : 1;
    }

    public function calculateMinutes(RotaInterface $rota): array
    {
        $this->rota = $rota;
        $shifts = $this->shiftRepository->fetchByRotaID($this->rota->getRotaID());
        $eventTimes = $this->createEventTimesList($shifts);

        $this->workingStaff = [];
        $this->soloStart = [];
        $this->singleMannings = [];

        foreach ($eventTimes as $event) {
            $this->processEvent($event);
        }

        return $this->singleMannings;
    }

    private function createEventTimesList(array $shifts): array
    {
        foreach ($shifts as $shift) {
            if ($shift instanceof ShiftInterface) {
                $eventTimes[] = [
                    'staffId' => $shift->getStaffID(),
                    'event' => self::SHIFT_START,
                    'time' => $shift->getStartTime()
                ];
                $eventTimes[] = [
                    'staffId' => $shift->getStaffID(),
                    'event' => self::SHIFT_END,
                    'time' => $shift->getEndTime()
                ];
            }
        }
        uasort($eventTimes, ['Scheduler\Processor\SingleManningProcessor', 'orderEventTimes']);

        return $eventTimes;
    }

    private function processEvent(array $event) {
        if ($event['event'] == self::SHIFT_START) {
            $this->workingStaff[$event['staffId']] = $event['staffId'];
        } elseif ($event['event'] == self::SHIFT_END) {
            if (isset($this->workingStaff[$event['staffId']])) {
                unset($this->workingStaff[$event['staffId']]);
            } else {
                throw new \Exception('Staff shift ended but not recorded as starting');
            }
        }

        if (count($this->workingStaff) == 1) {
            $staffId = array_values($this->workingStaff)[0];
            $this->soloStart = [
                'staffId' => $staffId,
                'time' => $event['time']
            ];
        }

        if (count($this->workingStaff) == 2 || count($this->workingStaff) == 0) {
            $this->processStaffSingleManningEntry($event);
        }
    }

    private function processStaffSingleManningEntry(array $event) {
        $interval = $this->soloStart['time']->diff($event['time']);
        $singleManningMinutes = ($interval->h * 60) + $interval->i;

        if (isset($this->singleMannings[$this->soloStart['staffId']])) {
            $singleManningMinutes += $this->singleMannings[$this->soloStart['staffId']]->getSingleManningMinutes();
        }

        $this->singleMannings[$this->soloStart['staffId']] = new SingleManning(
            1,
            $this->rota->getRotaID(),
            $this->soloStart['staffId'],
            $singleManningMinutes,
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );

        $this->soloStart;
    }
}
