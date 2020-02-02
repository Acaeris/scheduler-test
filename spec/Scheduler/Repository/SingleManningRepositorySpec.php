<?php

namespace spec\Scheduler\Repository;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Interfaces\SingleManningInterface;
use Scheduler\Repository\RepositoryInterface;
use Scheduler\Repository\SingleManningRepository;

class SingleManningRepositorySpec extends ObjectBehavior
{
    private $mockData = [
        [
            'singleManningId' => 1,
            'rotaId' => 2,
            'staffId' => 3,
            'singleManningMinutes' => 10,
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
        $this->shouldHaveType(SingleManningRepository::class);
        $this->shouldImplement(RepositoryInterface::class);
    }

    public function it_should_fetch_single_manning_data()
    {
        $this->fetch("")->shouldReturnArrayOfSingleMannings();
    }

    public function it_can_convert_data_to_single_manning_object()
    {
        $this->create($this->mockData[0])->shouldImplement(SingleManningInterface::class);
    }

    public function getMatchers(): array
    {
        return [
            'returnArrayOfSingleMannings' => function (array $singleMannings): bool
            {
                foreach ($singleMannings as $singleManning) {
                    if (!$singleManning instanceof SingleManningInterface) {
                        return false;
                    }
                }
                return true;
            }
        ];
    }
}