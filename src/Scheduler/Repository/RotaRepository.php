<?php

namespace Scheduler\Repository;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Rota;
use Scheduler\Entity\Interfaces\EntityInterface;

class RotaRepository implements RepositoryInterface
{
    /** @var Connection $connection */
    private $connection;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var array Rotas */
    private $rotas;

    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function create(array $rota): EntityInterface
    {
        return new Rota(
            $rota['rotaId'],
            $rota['shopId'],
            new \DateTimeImmutable($rota['weekCommence']),
            new \DateTimeImmutable($rota['createdAt']),
            new \DateTimeImmutable($rota['updatedAt'])
        );
    }

    public function fetch(string $query, array $where = []): array
    {
        $this->logger->debug('Fetching rotas from DB');
        $this->rotas = [];
        $this->processResults($this->connection->fetchAll($query, $where));
        $this->logger->debug(count($this->rotas).' rotas fetched from DB');

        return $this->rotas;
    }

    private function processResults(array $results)
    {
        if ($results !== false) {
            foreach ($results as $rota) {
                $this->rotas[$rota['rotaId']] = $this->create($rota);
            }
        }
    }
}