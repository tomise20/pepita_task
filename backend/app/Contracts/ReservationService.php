<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTOs\ReservationDto;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

interface ReservationService {
    /**
     * @return Collection<ReservationDto>
     */
    public function findAll(): Collection;

     /**
     * @return Collection<ReservationDto>
     */
    public function findAllByMonth(Carbon $date): Collection;

    public function reservation(ReservationDto $data): bool;
}