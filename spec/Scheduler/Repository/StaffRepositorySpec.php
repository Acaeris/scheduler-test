<?php

namespace spec\Scheduler\Repository;

use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Interfaces\StaffInterface;
use Scheduler\Repository\RepositoryInterface;
use Scheduler\Repository\StaffRepository;

class StaffRepositorySpec extends ObjectBehavior
{
    private $mockData = [
        [
            'staffId' => 1,
            'shopId' => 2,
            'firstName' => 'Black',
            'lastName' => 'Widow',
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
        $this->shouldHaveType(StaffRepository::class);
        $this->shouldImplement(RepositoryInterface::class);
    }

    public function it_should_fetch_staff_data()
    {
        $this->fetch("")->shouldReturnArrayOfStaff();
    }

    public function it_can_convert_data_to_staff_object()
    {
        $this->create($this->mockData[0])->shouldImplement(StaffInterface::class);
    }

    public function getMatchers(): array
    {
        return [
            'returnArrayOfStaff' => function (array $staff): bool
            {
                foreach ($staff as $employee) {
                    if (!$employee instanceof StaffInterface) {
                        return false;
                    }
                }
                return true;
            }
        ];
    }
}