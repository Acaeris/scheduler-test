<?php

namespace spec\Scheduler\Entity;

use PhpSpec\ObjectBehavior;
use Scheduler\Entity\Rota;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Entity\Interfaces\RotaInterface;
use Scheduler\Entity\Interfaces\TimestampsInterface;

class RotaSpec extends ObjectBehavior
{
    private $weekCommence;
    private $createdAt;
    private $updatedAt;

    public function let() {
        $this->weekCommence = new \DateTimeImmutable('2020-01-01');
        $this->createdAt = new \DateTimeImmutable('2020-01-01 08:30:00');
        $this->updatedAt = new \DateTimeImmutable('2020-01-02 09:00:00');

        $this->beConstructedWith(
            1, // Rota ID
            2, // Shop ID
            $this->weekCommence, // Week Commence
            $this->createdAt, // Created At
            $this->updatedAt // Updated At
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Rota::class);
        $this->shouldImplement(RotaInterface::class);
        $this->shouldImplement(TimestampsInterface::class);
    }

    public function it_is_immutable()
    {
        $this->shouldImplement(ImmutableInterface::class);
    }

    public function it_has_all_data_accessible()
    {
        $this->getRotaID()->shouldReturn(1);
        $this->getShopID()->shouldReturn(2);
        $this->getWeekCommence()->shouldReturn($this->weekCommence);
        $this->getCreatedAt()->shouldReturn($this->createdAt);
        $this->getUpdatedAt()->shouldReturn($this->updatedAt);
    }
}
