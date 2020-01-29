<?php

namespace spec\Scheduler\Entity;

use PhpSpec\ObjectBehavior;
use Scheduler\Entity\Shift;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Entity\Interfaces\ShiftInterface;
use Scheduler\Entity\Interfaces\TimestampsInterface;

class ShiftSpec extends ObjectBehavior
{
    private $startTime;
    private $endTime;
    private $createdAt;
    private $updatedAt;

    public function let() {
        $this->startTime = new \DateTimeImmutable('10am');
        $this->endTime = new \DateTimeImmutable('4pm');
        $this->createdAt = new \DateTimeImmutable('2020-01-01 08:30:00');
        $this->updatedAt = new \DateTimeImmutable('2020-01-02 09:00:00');

        $this->beConstructedWith(
            1, // Shift ID
            2, // Rota ID
            3, // Staff ID
            $this->startTime, // Start Time
            $this->endTime, // End Time
            $this->createdAt, // Created At
            $this->updatedAt // Updated At
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Shift::class);
        $this->shouldImplement(ShiftInterface::class);
        $this->shouldImplement(TimestampsInterface::class);
    }

    public function it_is_immutable()
    {
        $this->shouldImplement(ImmutableInterface::class);
    }

    public function it_has_all_data_accessible()
    {
        $this->getShiftID()->shouldReturn(1);
        $this->getRotaID()->shouldReturn(2);
        $this->getStaffID()->shouldReturn(3);
        $this->getStartTime()->shouldReturn($this->startTime);
        $this->getEndTime()->shouldReturn($this->endTime);
        $this->getCreatedAt()->shouldReturn($this->createdAt);
        $this->getUpdatedAt()->shouldReturn($this->updatedAt);
    }
}
