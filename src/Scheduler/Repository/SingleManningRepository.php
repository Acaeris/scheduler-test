<?php

namespace Scheduler\Repository;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Interfaces\EntityInterface;
use Scheduler\Entity\SingleManning;

class SingleManningRepository implements RepositoryInterface
{
    /** @var Connection $connection */
    private $connection;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var array Single Mannings */
    private $singleMannings;

    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function create(array $singleManning): EntityInterface
    {
        return new SingleManning(
            $singleManning['singleManningId'],
            $singleManning['rotaId'],
            $singleManning['staffId'],
            $singleManning['singleManningMinutes'],
            new \DateTimeImmutable($singleManning['createdAt']),
            new \DateTimeImmutable($singleManning['updatedAt'])
        );
    }

    public function fetch(string $query, array $where = []): array
    {
        $this->logger->debug('Fetching single manning entries from DB');
        $this->singleMannings = [];
        $this->processResults($this->connection->fetchAll($query, $where));
        $this->logger->debug(count($this->singleMannings).' single manning entries fetched from DB');

        return $this->singleMannings;
    }

    private function processResults(array $results)
    {
        if ($results !== false) {
            foreach ($results as $singleManning) {
                $this->singleMannings[$singleManning['singleManningId']] = $this->create($singleManning);
            }
        }
    }
}