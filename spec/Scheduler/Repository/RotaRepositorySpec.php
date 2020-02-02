<?php

namespace spec\Scheduler\Repository;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Interfaces\RotaInterface;
use Scheduler\Repository\RotaRepository;
use Scheduler\Repository\RepositoryInterface;

class RotaRepositorySpec extends ObjectBehavior
{
    private $mockData = [
        [
            'rotaId' => 1,
            'shopId' => 2,
            'weekCommence' => '2020-01-27',
            'createdAt' => '2020-01-01 12:00:00',
            'updatedAt' => '2020-01-01 13:00:00'
        ]
    ];

    public function let(
        Connection $connection,
        LoggerInterface $logger
    ) {
        $this->beConstructedWith($connection, $logger);
    }

    public function it_should_be_initializable()
    {
        $this->shouldHaveType(RotaRepository::class);
        $this->shouldImplement(RepositoryInterface::class);
    }

    public function it_should_fetch_rota_data(
        Connection $connection
    ) {
        $connection->fetchAll('', [])->willReturn($this->mockData);
        $this->fetch("")->shouldReturnArrayOfRotas();
    }

    public function it_should_fetch_rota_data_by_rota_id(
        Connection $connection
    ) {
        $connection->fetchAll('SELECT * FROM rotas WHERE rotaId = :rotaId', ['rotaId' => 1])->willReturn($this->mockData);
        $this->fetchByID(1)->shouldReturnArrayOfShifts();
    }

    public function it_can_convert_data_to_rota_object()
    {
        $this->create($this->mockData[0])->shouldImplement(RotaInterface::class);
    }

    public function getMatchers(): array
    {
        return [
            'returnArrayOfRotas' => function (array $rotas): bool
            {
                foreach ($rotas as $rota) {
                    if (!$rota instanceof RotaInterface) {
                        return false;
                    }
                }
                return true;
            }
        ];
    }
}