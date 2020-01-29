<?php

namespace Scheduler\Entity\Interfaces;

interface ShiftBreakInterface
{
    public function getShiftBreakID(): int;
    public function getShiftID(): int;
    public function getStartTime(): \DateTimeImmutable;
    public function getEndTime(): \DateTimeImmutable;
}