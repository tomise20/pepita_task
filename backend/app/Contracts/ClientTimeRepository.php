<?php

declare(strict_types=1);

namespace App\Contracts;

interface ClientTimeRepository
{
    public function checkClientTime(string $startDate, string $endDate, string $day): bool;
}