<?php

namespace Scheduler\Repository;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Interfaces\EntityInterface;
use Scheduler\Entity\Shift;

class ShiftRepository implements RepositoryInterface
{
    /** @var Connection $connection */
    private $connection;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var array Shifts */
    private $shifts;

    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function create(array $shift): EntityInterface
    {
        return new Shift(
            $shift['shiftId'],
            $shift['rotaId'],
            $shift['staffId'],
            new \DateTimeImmutable($shift['startTime']),
            new \DateTimeImmutable($shift['endTime']),
            new \DateTimeImmutable($shift['createdAt']),
            new \DateTimeImmutable($shift['updatedAt'])
        );
    }

    public function fetch(string $query, array $where = []): array
    {
        $this->logger->debug('Fetching shifts from DB');
        $this->shifts = [];
        $this->processResults($this->connection->fetchAll($query, $where));
        $this->logger->debug(count($this->shifts).' shifts fetch from DB');

        return $this->shifts;
    }

    public function fetchByRotaID(int $rotaID): array
    {
        return $this->fetch('SELECT * FROM shifts WHERE rotaId = :rotaId', ['rotaId' => $rotaID]);
    }

    private function processResults(array $results)
    {
        if ($results !== false) {
            foreach ($results as $shift) {
                $this->shifts[$shift['shiftId']] = $this->create($shift);
            }
        }
    }
}