<?php

namespace Scheduler\Entity\Interfaces;

interface RotaInterface
{
    public function getRotaID(): int;
    public function getShopID(): int;
    public function getWeekCommence(): \DateTimeImmutable;
}