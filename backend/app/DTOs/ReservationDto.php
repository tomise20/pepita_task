<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Models\Reservation;
use DateTime;
use Illuminate\Support\Carbon;

class ReservationDto {
    
    public int $id;
    public string $name;
    public DateTime $startDate;
    public ?DateTime $endDate;
    public string $startTime;
    public string $endTime;
    public string $repeate;
    public ?string $repeateDay;
    

    public static function from(array $data): self {
        $entity = new self();
        $entity->name = $data['name'];
        $entity->startDate = Carbon::parse($data['startDate']);
        $entity->endDate = isset($data['endDate']) ? Carbon::parse($data['endDate']) : null;
        $entity->startTime = $data['startTime'];
        $entity->endTime = $data['endTime'];
        $entity->repeate = $data['repeate'];
        $entity->repeateDay = $data['repeateDay'] ?? null;

        return $entity;
    }

    public static function fromModel(Reservation $model): self
    {
        $entity = new self();
        $entity->id = $model->id;
        $entity->name = $model->name;
        $entity->startDate = Carbon::parse($model->start_date);
        $entity->endDate = Carbon::parse($model->end_date);
        $entity->startTime = $model->start_time;
        $entity->endTime = $model->end_time;
        $entity->repeate = $model->repeate;
        $entity->repeateDay = $model->repeate_day;

        return $entity;
    }
}