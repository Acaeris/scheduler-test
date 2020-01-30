<?php

namespace spec\Scheduler\Repository;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Interfaces\ShopInterface;
use Scheduler\Repository\RepositoryInterface;
use Scheduler\Repository\ShopRepository;

class ShopRepositorySpec extends ObjectBehavior
{
    private $mockData = [
        [
            'shopId' => 2,
            'shopName' => 'FunHouse',
            'createdAt' => '2020-01-01 12:00:00',
            'updatedAt' => '2020-01-01 13:00:00'
        ]
    ];

    public function let(
        Connection $connection,
        LoggerInterface $logger
    ) {
        $connection->fetchAll('', [])->willReturn($this->mockData);
        $this->beConstructedWith($connection, $logger);
    }

    public function it_should_be_initializable()
    {
        $this->shouldHaveType(ShopRepository::class);
        $this->shouldImplement(RepositoryInterface::class);
    }

    public function it_should_fetch_shop_data()
    {
        $this->fetch("")->shouldReturnArrayOfShops();
    }

    public function it_can_convert_data_to_shop_object()
    {
        $this->create($this->mockData[0])->shouldImplement(ShopInterface::class);
    }

    public function getMatchers(): array
    {
        return [
            'returnArrayOfShops' => function (array $shops): bool
            {
                foreach ($shops as $shop) {
                    if (!$shop instanceof ShopInterface) {
                        return false;
                    }
                }
                return true;
            }
        ];
    }
}