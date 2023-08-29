<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTOs\ReservationDto;
use App\Models\Reservation;
use Illuminate\Support\Collection;

interface Mapper {
    public function single(Reservation $model): ReservationDto;

    /**
     * @param Collection<ReservationDto> $models
     * 
     * @return Collection<ReservationDto>
     */
    public function collection(Collection $models): Collection;
}