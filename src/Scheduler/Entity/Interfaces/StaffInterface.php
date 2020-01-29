<?php

namespace Scheduler\Entity\Interfaces;

interface StaffInterface
{
    public function getStaffID(): int;
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getShopID(): int;
}