<?php

namespace spec\Scheduler\Entity;

use PhpSpec\ObjectBehavior;
use Scheduler\Entity\Staff;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Entity\Interfaces\StaffInterface;
use Scheduler\Entity\Interfaces\TimestampsInterface;

class StaffSpec extends ObjectBehavior
{
    private $createdAt;
    private $updatedAt;

    public function let() {
        $this->createdAt = new \DateTimeImmutable('2020-01-01 08:30:00');
        $this->updatedAt = new \DateTimeImmutable('2020-01-02 09:00:00');

        $this->beConstructedWith(
            1, // Staff ID
            'Black', // First Name
            'Widow', // Last Name
            2, // Shop ID
            $this->createdAt, // Created At
            $this->updatedAt // Updated At
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Staff::class);
        $this->shouldImplement(StaffInterface::class);
        $this->shouldImplement(TimestampsInterface::class);
    }

    public function it_is_immutable()
    {
        $this->shouldImplement(ImmutableInterface::class);
    }

    public function it_has_all_data_accessible()
    {
        $this->getStaffID()->shouldReturn(1);
        $this->getFirstName()->shouldReturn('Black');
        $this->getLastName()->shouldReturn('Widow');
        $this->getShopID()->shouldReturn(2);
        $this->getCreatedAt()->shouldReturn($this->createdAt);
        $this->getUpdatedAt()->shouldReturn($this->updatedAt);
    }
}
