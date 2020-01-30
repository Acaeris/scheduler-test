<?php

namespace Scheduler\Repository;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Scheduler\Entity\Shop;
use Scheduler\Entity\Interfaces\EntityInterface;

class ShopRepository implements RepositoryInterface
{
    /** @var Connection $connection */
    private $connection;

    /** @var LoggerInterface $logger */
    private $logger;

    /** @var array Shops */
    private $shops;

    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function create(array $rota): EntityInterface
    {
        return new Shop(
            $rota['shopId'],
            $rota['shopName'],
            new \DateTimeImmutable($rota['createdAt']),
            new \DateTimeImmutable($rota['updatedAt'])
        );
    }

    public function fetch(string $query, array $where = []): array
    {
        $this->logger->debug('Fetching shops from DB');
        $this->shops = [];
        $this->processResults($this->connection->fetchAll($query, $where));
        $this->logger->debug(count($this->shops).' shops fetched from DB');

        return $this->shops;
    }

    private function processResults(array $results)
    {
        if ($results !== false) {
            foreach ($results as $shop) {
                $this->shops[$shop['shopId']] = $this->create($shop);
            }
        }
    }
}