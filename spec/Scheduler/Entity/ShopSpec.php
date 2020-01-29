<?php

namespace spec\Scheduler\Entity;

use PhpSpec\ObjectBehavior;
use Scheduler\Entity\Shop;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Entity\Interfaces\ShopInterface;
use Scheduler\Entity\Interfaces\TimestampsInterface;

class ShopSpec extends ObjectBehavior
{
    private $createdAt;
    private $updatedAt;

    public function let() {
        $this->createdAt = new \DateTimeImmutable('2020-01-01 08:30:00');
        $this->updatedAt = new \DateTimeImmutable('2020-01-02 09:00:00');

        $this->beConstructedWith(
            1, // Shop ID
            'FunHouse', // Shop Name
            $this->createdAt, // Created At
            $this->updatedAt // Updated At
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Shop::class);
        $this->shouldImplement(ShopInterface::class);
        $this->shouldImplement(TimestampsInterface::class);
    }

    public function it_is_immutable()
    {
        $this->shouldImplement(ImmutableInterface::class);
    }

    public function it_has_all_data_accessible()
    {
        $this->getShopID()->shouldReturn(1);
        $this->getShopName()->shouldReturn('FunHouse');
        $this->getCreatedAt()->shouldReturn($this->createdAt);
        $this->getUpdatedAt()->shouldReturn($this->updatedAt);
    }
}
