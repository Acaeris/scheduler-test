<?php

namespace Scheduler\Entity;

use Scheduler\Entity\Interfaces\ShopInterface;
use Scheduler\Entity\Interfaces\TimestampsInterface;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Library\Immutable\ImmutableTrait;

class Shop implements ImmutableInterface, ShopInterface, TimestampsInterface
{
    use ImmutableTrait {
        __construct as constructImmutable;
    }

    /** @var int Shop ID */
    private $shopId;

    /** @var string Shop Name */
    private $shopName;

    /** @var \DateTimeImmutable Created At */
    private $createdAt;

    /** @var \DateTimeImmutable Updated At */
    private $updatedAt;

    public function __construct(
        int $shopId,
        string $shopName,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->shopId = $shopId;
        $this->shopName = $shopName;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;

        $this->constructImmutable();
    }

    public function getShopID(): int
    {
        return $this->shopId;
    }

    public function getShopName(): string
    {
        return $this->shopName;
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