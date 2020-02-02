<?php

namespace Scheduler\Entity;

use Scheduler\Entity\Interfaces\EntityInterface;
use Scheduler\Entity\Interfaces\TimestampsInterface;
use Scheduler\Entity\Interfaces\SingleManningInterface;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Library\Immutable\ImmutableTrait;

class SingleManning implements ImmutableInterface, SingleManningInterface, TimestampsInterface, EntityInterface
{
    use ImmutableTrait {
        __construct as constructImmutable;
    }

    /** @var int Single Manning ID */
    private $singleManningId;

    /** @var int Rota ID */
    private $rotaId;

    /** @var int Staff ID */
    private $staffId;

    /** @var int Single Manning Minutes */
    private $singleManningMinutes;

    /** @var \DateTimeImmutable Created At */
    private $createdAt;

    /** @var \DateTimeImmutable Updated At */
    private $updatedAt;

    public function __construct(
        int $singleManningId,
        int $rotaId,
        int $staffId,
        int $singleManningMinutes,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->singleManningId = $singleManningId;
        $this->rotaId = $rotaId;
        $this->staffId = $staffId;
        $this->singleManningMinutes = $singleManningMinutes;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;

        $this->constructImmutable();
    }

    public function getSingleManningID(): int
    {
        return $this->singleManningId;
    }

    public function getRotaID(): int
    {
        return $this->rotaId;
    }

    public function getStaffID(): int
    {
        return $this->staffId;
    }

    public function getSingleManningMinutes(): int
    {
        return $this->singleManningMinutes;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getKeyData(): array
    {
        return [
            'singleManningId' => $this->singleManningId
        ];
    }
}