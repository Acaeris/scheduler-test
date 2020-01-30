<?php

namespace Scheduler\Repository;

use Scheduler\Entity\Interfaces\EntityInterface;

interface RepositoryInterface
{
    public function create(array $data): EntityInterface;
    public function fetch(string $query, array $where = []): array;
}