<?php

namespace spec\Scheduler\Entity;

use PhpSpec\ObjectBehavior;
use Scheduler\Entity\ShiftBreak;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Entity\Interfaces\ShiftBreakInterface;

class ShiftBreakSpec extends ObjectBehavior
{
    private $startTime;
    private $endTime;

    public function let() {
        $this->startTime = new \DateTimeImmutable('12am');
        $this->endTime = new \DateTimeImmutable('1pm');

        $this->beConstructedWith(
            1, // Shift Break ID
            2, // Shift ID
            $this->startTime, // Start Time
            $this->endTime // End Time
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ShiftBreak::class);
        $this->shouldImplement(ShiftBreakInterface::class);
    }

    public function it_is_immutable()
    {
        $this->shouldImplement(ImmutableInterface::class);
    }

    public function it_has_all_data_accessible()
    {
        $this->getShiftBreakID()->shouldReturn(1);
        $this->getShiftID()->shouldReturn(2);
        $this->getStartTime()->shouldReturn($this->startTime);
        $this->getEndTime()->shouldReturn($this->endTime);
    }
}
