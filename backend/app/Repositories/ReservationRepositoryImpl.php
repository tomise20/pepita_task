<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ReservationRepository;
use App\DTOs\ReservationDto;
use App\Enums\RepeateOptions;
use App\Mappers\ReservationMapper;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ReservationRepositoryImpl implements ReservationRepository
{
    function __construct(private readonly ReservationMapper $mapper)
    {
    }

    public function findAll(): Collection
    {
        return collect();
    }

    public function findAllByDate(Carbon $date): Collection
    {
        $events = Reservation::query()
            ->where(function(Builder $query) use($date) {
                $query->whereYear('start_date', '=', $date->year)
                    ->whereMonth('start_date', '<=', $date->month);
            })
            ->where('end_date', '=', null)
            ->orWhere(function(Builder $query) use($date) {
                $query->whereYear('end_date', '=', $date->year)
                    ->whereMonth('end_date', '>=', $date->month);
            })
            ->get();

        return $this->mapper->collection($events);
    }

    public function store(ReservationDto $dto): bool
    {
        $reservation = new Reservation();
        $reservation->name = $dto->name;
        $reservation->start_date = $dto->startDate;
        $reservation->end_date = $dto->endDate;
        $reservation->start_time = $dto->startTime;
        $reservation->end_time = $dto->endTime;
        $reservation->repeate = $dto->repeate;
        $reservation->repeate_day = $dto->repeateDay;
        
        return $reservation->save();
    }

    public function check(ReservationDto &$dto): bool
    {
        $day = strtoupper(Carbon::parse($dto->startDate)->dayName);
        $isOddWeek = Carbon::parse($dto->startDate)->week % 2 == 1;

        return Reservation::query()
            ->where(function(Builder $query) use($day, $dto) {
                $query
                    ->where('start_date', '=', $dto->startDate)
                    ->orWhere('repeate_day', '=', $day)
                    ->where(function(Builder $query) use($dto) {
                        $query
                            ->where(function(EloquentBuilder $query) use($dto) {
                                $query->where('start_time', '<=', $dto->startTime)
                                    ->where('end_time', '>', $dto->startTime);
                            })
                            ->orWhere(function(EloquentBuilder $query) use($dto) {
                                $query->where('start_time', '>=', $dto->startTime)
                                    ->where('end_time', '<=', $dto->endTime);
                            });
                    });
            })
            ->when($isOddWeek, function(Builder $query) use($day, $dto) {
                $query->orWhere('repeate', '=', RepeateOptions::ODDWEEKS->value)
                    ->where('repeate_day', '=', $day)
                    ->where(function(Builder $query) use($dto) {
                        $query
                            ->where(function(EloquentBuilder $query) use($dto) {
                                $query->where('start_time', '<=', $dto->startTime)
                                    ->where('end_time', '>=', $dto->startTime);
                            })
                            ->orWhere(function(EloquentBuilder $query) use($dto) {
                                $query->where('start_time', '>=', $dto->startTime)
                                    ->where('end_time', '<=', $dto->endTime);
                            });
                    });
            },function(Builder $query) use($day, $dto) {
                $query->orWhere('repeate', '=', RepeateOptions::EVENWEEKS->value)
                    ->where('repeate_day', '=', $day)
                    ->where(function(Builder $query) use($dto) {
                        $query
                            ->where(function(EloquentBuilder $query) use($dto) {
                                $query->where('start_time', '<=', $dto->startTime)
                                    ->where('end_time', '>=', $dto->startTime);
                            })
                            ->orWhere(function(EloquentBuilder $query) use($dto) {
                                $query->where('start_time', '>=', $dto->startTime)
                                    ->where('end_time', '<=', $dto->endTime);
                            });
                    });
            })
            ->exists();
    }
}

