<?php

namespace Scheduler\Entity\Interfaces;

interface ShiftInterface
{
    public function getShiftID(): int;
    public function getRotaID(): int;
    public function getStaffID(): int;
    public function getStartTime(): \DateTimeImmutable;
    public function getEndTime(): \DateTimeImmutable;
}