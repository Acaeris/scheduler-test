<?php

namespace Scheduler\Entity\Interfaces;

interface TimestampsInterface
{
    public function getCreatedAt(): \DateTimeImmutable;
    public function getUpdatedAt(): \DateTimeImmutable;
}