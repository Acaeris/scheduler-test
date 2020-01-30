<?php

namespace Scheduler\Repository;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Staff;
use Scheduler\Entity\Interfaces\EntityInterface;

class StaffRepository implements RepositoryInterface
{
    /** @var Connection $connection */
    private $connection;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var array Rotas */
    private $staff;

    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function create(array $employee): EntityInterface
    {
        return new Staff(
            $employee['staffId'],
            $employee['firstName'],
            $employee['lastName'],
            $employee['shopId'],
            new \DateTimeImmutable($employee['createdAt']),
            new \DateTimeImmutable($employee['updatedAt'])
        );
    }

    public function fetch(string $query, array $where = []): array
    {
        $this->logger->debug('Fetching staff from DB');
        $this->staff = [];
        $this->processResults($this->connection->fetchAll($query, $where));
        $this->logger->debug(count($this->staff).' members of staff fetched from DB');

        return $this->staff;
    }

    private function processResults(array $results)
    {
        if ($results !== false) {
            foreach ($results as $employee) {
                $this->staff[$employee['staffId']] = $this->create($employee);
            }
        }
    }
}