<?php

namespace Scheduler\Entity;

use Scheduler\Entity\Interfaces\EntityInterface;
use Scheduler\Entity\Interfaces\ShiftBreakInterface;
use Scheduler\Library\Immutable\ImmutableInterface;
use Scheduler\Library\Immutable\ImmutableTrait;

class ShiftBreak implements ImmutableInterface, ShiftBreakInterface, EntityInterface
{
    use ImmutableTrait {
        __construct as constructImmutable;
    }

    /** @var int Shift Break ID */
    private $shiftBreakId;

    /** @var int Shift ID */
    private $shiftId;

    /** @var \DateTimeImmutable Start Time */
    private $startTime;

    /** @var \DateTimeImmutable End Time */
    private $endTime;

    public function __construct(
        int $shiftBreakId,
        int $shiftId,
        \DateTimeImmutable $startTime,
        \DateTimeImmutable $endTime
    ) {
        $this->shiftBreakId = $shiftBreakId;
        $this->shiftId = $shiftId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function getShiftBreakID(): int
    {
        return $this->shiftBreakId;
    }

    public function getShiftID(): int
    {
        return $this->shiftId;
    }

    public function getStartTime(): \DateTimeImmutable
    {
        return $this->startTime;
    }

    public function getEndTime(): \DateTimeImmutable
    {
        return $this->endTime;
    }

    public function getKeyData(): array
    {
        return [
            'shiftBreakId' => $this->shiftBreakId
        ];
    }
}