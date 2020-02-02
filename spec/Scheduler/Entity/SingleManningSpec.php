<?php

namespace spec\Scheduler\Entity;

use PhpSpec\ObjectBehavior;
use Scheduler\Entity\Interfaces\EntityInterface;
use Scheduler\Entity\Interfaces\SingleManningInterface;
use Scheduler\Entity\SingleManning;
use Scheduler\Library\Immutable\ImmutableException;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Entity\Interfaces\TimestampsInterface;

class SingleManningSpec extends ObjectBehavior
{
    private $createdAt;
    private $updatedAt;

    public function let() {
        $this->createdAt = new \DateTimeImmutable('2020-01-01 08:30:00');
        $this->updatedAt = new \DateTimeImmutable('2020-01-02 09:00:00');

        $this->beConstructedWith(
            1, // Single Manning ID
            2, // Rota ID
            3, // Staff ID
            10, // Single Manning minutes
            $this->createdAt, // Created At
            $this->updatedAt // Updated At
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SingleManning::class);
        $this->shouldImplement(SingleManningInterface::class);
        $this->shouldImplement(TimestampsInterface::class);
        $this->shouldImplement(EntityInterface::class);
    }

    public function it_is_immutable()
    {
        $this->shouldImplement(ImmutableInterface::class);
        $this->shouldThrow(ImmutableException::class)->during('__set', ['singleManningId', 1]);
    }

    public function it_can_return_key_data_for_indexing()
    {
        $this->getKeyData()->shouldReturn([
            'singleManningId' => 1
        ]);
    }

    public function it_has_all_data_accessible() {
        $this->getSingleManningID()->shouldReturn(1);
        $this->getRotaID()->shouldReturn(2);
        $this->getStaffID()->shouldReturn(3);
        $this->getSingleManningMinutes()->shouldReturn(10);
        $this->getCreatedAt()->shouldReturn($this->createdAt);
        $this->getUpdatedAt()->shouldReturn($this->updatedAt);
    }
}
