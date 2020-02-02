<?php

namespace Scheduler\Repository;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Interfaces\EntityInterface;
use Scheduler\Entity\ShiftBreak;

class ShiftBreakRepository implements RepositoryInterface
{
    /** @var Connection $connection */
    private $connection;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var array Shift Breaks */
    private $shiftBreaks;

    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function create(array $shiftBreak): EntityInterface
    {
        return new ShiftBreak(
            $shiftBreak['shiftBreakId'],
            $shiftBreak['shiftId'],
            new \DateTimeImmutable($shiftBreak['startTime']),
            new \DateTimeImmutable($shiftBreak['endTime'])
        );
    }

    public function fetch(string $query, array $where = []): array
    {
        $this->logger->debug('Fetching shift breaks from DB');
        $this->shiftBreaks;
        $this->processResults($this->connection->fetchAll($query, $where));
        $this->logger->debug(count($this->shiftBreaks).' shift breaks fetched from DB');

        return $this->shiftBreaks;
    }

    public function fetchByShiftID(int $shiftId): array
    {
        return $this->fetch('SELECT * FROM shiftBreaks WHERE shiftId = :shiftId', ['shiftId' => $shiftId]);
    }

    private function processResults(array $results)
    {
        if ($results !== false) {
            foreach ($results as $shiftBreak) {
                $this->shiftBreaks[$shiftBreak['shiftBreakId']] = $this->create($shiftBreak);
            }
        }
    }
}