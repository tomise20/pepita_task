<?php

namespace App\Services;

use App\Contracts\ClientTimeRepository;
use App\Contracts\ClientTimeService;
use App\DTOs\ReservationDto;
use Illuminate\Support\Carbon;

class ClientTimeServiceImpl implements ClientTimeService
{
    function __construct(private readonly ClientTimeRepository $clientTimeRepository)
    {
    }

    public function checkClientTime(ReservationDto $data): bool
    {
        if($data->repeateDay) {
            $day = $data->repeateDay;
        } else {
            $day = strtoupper(Carbon::parse($data->startDate)->dayName); 
        }

        return $this->clientTimeRepository->checkClientTime($data->startTime, $data->endTime, $day);
    }
}