<?php

namespace App\Mappers;

use App\Contracts\Mapper;
use App\DTOs\ReservationDto;
use App\Models\Reservation;
use Illuminate\Support\Collection;

class ReservationMapper implements Mapper
{
    public function single(Reservation $model): ReservationDto
    {
        return ReservationDto::fromModel($model);
    }

    /**
     * @return Collection<ReservationDto>
     */
    public function collection(Collection $models): Collection
    {
        return $models->map(fn(Reservation $model) => $this->single($model));
    }
}