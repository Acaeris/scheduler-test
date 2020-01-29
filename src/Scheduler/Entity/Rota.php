<?php

namespace Scheduler\Entity;

use Scheduler\Entity\Interfaces\RotaInterface;
use Scheduler\Entity\Interfaces\TimestampsInterface;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Library\Immutable\ImmutableTrait;

class Rota implements ImmutableInterface, RotaInterface, TimestampsInterface
{
    use ImmutableTrait {
        __construct as constructImmutable;
    }

    /** @var int Rota ID */
    private $rotaId;

    /** @var int Shop ID */
    private $shopId;

    /** @var \DateTimeImmutable Week Commence */
    private $weekCommence;

    /** @var \DateTimeImmutable Created At */
    private $createdAt;

    /** @var \DateTimeImmutable Updated At */
    private $updatedAt;

    public function __construct(
        int $rotaId,
        int $shopId,
        \DateTimeImmutable $weekCommence,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->rotaId = $rotaId;
        $this->shopId = $shopId;
        $this->weekCommence = $weekCommence;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getRotaID(): int
    {
        return $this->rotaId;
    }

    public function getShopID(): int
    {
        return $this->shopId;
    }

    public function getWeekCommence(): \DateTimeImmutable
    {
        return $this->weekCommence;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}