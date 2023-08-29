<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTOs\ReservationDto;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

interface ReservationRepository {

    /**
     * @return Collection<ReservationDto>
     */
    public function findAll(): Collection;

    /**
     * @return Collection<ReservationDto>
     */
    public function findAllByDate(Carbon $date): Collection;

    public function store(ReservationDto $dto): bool;

    public function check(ReservationDto &$dto): bool;
}