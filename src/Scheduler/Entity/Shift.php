<?php

namespace Scheduler\Entity;

use Scheduler\Entity\Interfaces\EntityInterface;
use Scheduler\Entity\Interfaces\ShiftInterface;
use Scheduler\Entity\Interfaces\TimestampsInterface;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Library\Immutable\ImmutableTrait;

final class Shift implements ImmutableInterface, ShiftInterface, TimestampsInterface, EntityInterface
{
    use ImmutableTrait {
        __construct as constructImmutable;
    }

    /** @var int Shift ID */
    private $shiftId;

    /** @var int Rota ID */
    private $rotaId;

    /** @var int Staff ID */
    private $staffId;

    /** @var \DateTime Start Time */
    private $startTime;

    /** @var \DateTime End Time */
    private $endTime;

    /** @var \DateTime Created At */
    private $createdAt;

    /** @var \DateTime Updated At */
    private $updatedAt;

    public function __construct(
        int $shiftId,
        int $rotaId,
        int $staffId,
        \DateTimeImmutable $startTime,
        \DateTimeImmutable $endTime,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ) {
        $this->shiftId = $shiftId;
        $this->rotaId = $rotaId;
        $this->staffId = $staffId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;

        $this->constructImmutable();
    }

    public function getShiftID(): int
    {
        return $this->shiftId;
    }

    public function getRotaID(): int
    {
        return $this->rotaId;
    }

    public function getStaffID(): int
    {
        return $this->staffId;
    }

    public function getStartTime(): \DateTimeImmutable
    {
        return $this->startTime;
    }

    public function getEndTime(): \DateTimeImmutable
    {
        return $this->endTime;
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
            'shiftId' => $this->shiftId
        ];
    }
}
