<?php

namespace Scheduler\Entity\Interfaces;

interface SingleManningInterface
{
    public function getSingleManningID(): int;
    public function getRotaID(): int;
    public function getStaffID(): int;
    public function getSingleManningMinutes(): int;
}