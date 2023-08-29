<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ClientTimeService;
use App\Contracts\ReservationRepository;
use App\Contracts\ReservationService;
use App\DTOs\ReservationDto;
use App\Enums\RepeateOptions;
use App\Exceptions\ClientTimeException;
use App\Exceptions\ReservationException;
use App\Views\ReservationEventView;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ReservationServiceImpl implements ReservationService
{
    const DAYS_IN_WEEKS = 7;

    function __construct(
        private readonly ReservationRepository $reservationRepository,
        private readonly ClientTimeService $clientTimeService
    )
    {
    }

    public function findAll(): Collection
    {
        return $this->reservationRepository->findAll();
    }

    public function findAllByMonth(Carbon $date): Collection
    {
        $events = $this->reservationRepository->findAllByDate($date);

        return $this->generateAllEvents($events, $date);
    }

    public function reservation(ReservationDto $data): bool
    {
        if(!$this->clientTimeService->checkClientTime($data)) {
            throw new ClientTimeException('A megadott időpont nem ügyfélfogadási időben van!');
        }

        if($this->checkTimeIsReserved($data)) {
            throw new ReservationException('A megadott időpontra már van foglalás!');
        }
        
        return $this->reservationRepository->store($data);
    }

    private function checkTimeIsReserved(ReservationDto &$dto): bool
    {
        return $this->reservationRepository->check($dto);
    }

    /**
     * 
     * @param Collection<ReservationDto>
     *
     * @return  Collection<ReservationDto>
     */
    private function generateAllEvents(Collection $events, $date): Collection
    {
        $allEvents = collect();

        /**
         * @var ReservationDto $reservation
         */
        foreach ($events as $reservation) {
            if($reservation->repeate == 'NEVER') {
                $startDate = Carbon::parse($reservation->startDate)->setTimeFrom($reservation->startTime)->format('Y-m-d H:i');
                $endDate = Carbon::parse($reservation->endDate ?? $reservation->startDate)->setTimeFrom($reservation->endTime)->format('Y-m-d H:i');
                $event = new ReservationEventView($reservation->id, $reservation->name, $startDate, $endDate);

                $allEvents->push($event);
                continue;
            }
            
            $allEvents->push(...$this->generateDatesForEvent($reservation, $date));
        }

        return $allEvents;
    }

     /**
     * 
     * @param ReservationDto
     *
     * @return  array<ReservationDto>
     */
    private function generateDatesForEvent(ReservationDto $reservation, Carbon $inputDate): array
    {
        $events = [];
        $repeateDay = Str::ucfirst($reservation->repeateDay);
        $now = $inputDate->firstOfMonth();
        $date = strtoupper($now->dayName) === $reservation->repeateDay ? $now : $now->copy()->modify("next $repeateDay");
        $isOddWeek = $date->week % 2 == 1;

        //set the start date
        if($reservation->repeate === RepeateOptions::ODDWEEKS->value) {
            if(!$isOddWeek) {
                $date = $date->copy()->addWeek();
            }
        } else if($reservation->repeate === RepeateOptions::EVENWEEKS->value){
            
            if($isOddWeek) {
                $date = $date->copy()->addWeek();
            }
        }

        // Set the end date
        if($reservation->endDate !== null && $reservation->endDate < $now->lastOfMonth()) {
            $toDate = $reservation->endDate;
        } else {
            $toDate = $inputDate->endOfMonth();
        }

        
        while ($date->lt($toDate)) {
            $startEventDate = $date->copy()->setTimeFrom($reservation->startTime)->format('Y-m-d H:i');;
            $endEventDate = $date->copy()->setTimeFrom($reservation->endTime)->format('Y-m-d H:i');;
            $event = new ReservationEventView($reservation->id, $reservation->name, $startEventDate, $endEventDate);
            
            $events[] = $event;
            if($reservation->repeate == RepeateOptions::EVERYWEEK->value) {
                $date->addWeek();
            } else {
                $date->addWeeks(2);
            }
        }

        return $events;
    }

}