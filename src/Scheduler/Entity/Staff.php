<?php

namespace Scheduler\Entity;

use Scheduler\Entity\Interfaces\TimestampsInterface;
use Scheduler\Entity\Interfaces\StaffInterface;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Library\Immutable\ImmutableTrait;

class Staff implements ImmutableInterface, StaffInterface, TimestampsInterface
{
    use ImmutableTrait {
        __construct as constructImmutable;
    }

    /** @var int Staff ID */
    private $staffId;

    /** @var string First Name */
    private $firstName;

    /** @var string Last Name */
    private $lastName;

    /** @var Shop ID */
    private $shopId;

    /** @var Created At */
    private $createdAt;

    /** @var Updated At */
    private $updatedAt;

    public function __construct(
        int $staffId,
        string $firstName,
        string $lastName,
        int $shopId,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->staffId = $staffId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->shopId = $shopId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;

        $this->constructImmutable();
    }

    public function getStaffID(): int
    {
        return $this->staffId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getShopID(): int
    {
        return $this->shopId;
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