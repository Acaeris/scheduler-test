<?php

namespace spec\Scheduler\Repository;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Interfaces\ShiftBreakInterface;
use Scheduler\Repository\RepositoryInterface;
use Scheduler\Repository\ShiftBreakRepository;

class ShiftBreakRepositorySpec extends ObjectBehavior
{
    private $mockData = [
        [
            'shiftBreakId' => 1,
            'shiftId' => 2,
            'startTime' => '12:00',
            'endTime' => '13:00'
        ]
    ];

    public function let(
        Connection $connection,
        LoggerInterface $logger
    ) {
        $connection->fetchAll('', [])->willReturn($this->mockData);
        $this->beConstructedWith($connection, $logger);
    }

    public function it_should_be_initizable()
    {
        $this->shouldHaveType(ShiftBreakRepository::class);
        $this->shouldImplement(RepositoryInterface::class);
    }

    public function it_should_fetch_shift_break_data()
    {
        $this->fetch("")->shouldReturnArrayOfShiftBreaks();
    }

    public function it_can_convert_data_to_shift_break_object()
    {
        $this->create($this->mockData[0])->shouldImplement(ShiftBreakInterface::class);
    }

    public function getMatchers(): array
    {
        return [
            'returnArrayOfShiftBreaks' => function (array $shiftBreaks): bool
            {
                foreach ($shiftBreaks as $shiftBreak) {
                    if (!$shiftBreak instanceof ShiftBreakInterface) {
                        return false;
                    }
                }
                return true;
            }
        ];
    }
}