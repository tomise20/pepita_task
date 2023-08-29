<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ClientTimeRepository;
use App\Models\ClientTime;

class ClientTimeRepositoryImpl implements ClientTimeRepository
{
    public function checkClientTime(string $startDate, string $endDate, string $day): bool
    {
        return ClientTime::query()->where('start_time', '<=', $startDate)->where('end_time', '>=', $endDate)->where('day', '=', $day)->exists();
    }
}