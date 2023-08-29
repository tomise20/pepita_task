<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTOs\ReservationDto;

interface ClientTimeService {
    public function checkClientTime(ReservationDto $data): bool;
}