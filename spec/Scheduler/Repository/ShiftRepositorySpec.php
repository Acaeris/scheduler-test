<?php

namespace spec\Scheduler\Repository;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Interfaces\ShiftInterface;
use Scheduler\Repository\RepositoryInterface;
use Scheduler\Repository\ShiftRepository;
use Scheduler\Repository\ShiftBreakRepository;

class ShiftRepositorySpec extends ObjectBehavior
{
    private $mockData = [
        [
            'shiftId' => 1,
            'rotaId' => 2,
            'staffId' => 3,
            'startTime' => '09:00',
            'endTime' => '17:30',
            'createdAt' => '2020-01-01 12:00:00',
            'updatedAt' => '2020-01-01 13:00:00'
        ]
    ];

    public function let(
        Connection $connection,
        LoggerInterface $logger
    ) {
        $connection->fetchAll('',  [])->willReturn($this->mockData);
        $this->beConstructedWith($connection, $logger);
    }

    public function it_should_be_initializable()
    {
        $this->shouldHaveType(ShiftRepository::class);
        $this->shouldImplement(RepositoryInterface::class);
    }

    public function it_should_fetch_shift_data()
    {
        $this->fetch('')->shouldReturnArrayOfShifts();
    }

    public function it_can_convert_data_to_shift_object()
    {
        $this->create($this->mockData[0])->shouldImplement(ShiftInterface::class);
    }

    public function getMatchers(): array
    {
        return [
            'returnArrayOfShifts' => function (array $shifts): bool
            {
                foreach ($shifts as $shift) {
                    if (!$shift instanceof ShiftInterface) {
                        return false;
                    }
                }
                return true;
            }
        ];
    }
}