<?php

namespace Scheduler\Entity\Interfaces;

interface ShopInterface
{
    public function getShopID(): int;
    public function getShopName(): string;
}