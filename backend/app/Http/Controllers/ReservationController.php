<?php

namespace App\Http\Controllers;

use App\Contracts\ReservationService;
use App\DTOs\ReservationDto;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Log;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{
    function __construct(private readonly ReservationService $reservationService)
    {
    }

    public function findByDate(Request $request): JsonResponse 
    {
        if($request->query('date')) {
            $month = Carbon::parse($request->query('date'))->firstOfMonth();
        } else {
            $month = Carbon::now();
        }

        try {
            $events = $this->reservationService->findAllByMonth($month);
        } catch (\Exception $ex) {
            return response()->json([
                'errors' => $ex->getMessage(),
                'isSuccess' => false
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'body' => $events,
            'isSuccess' => true
        ]); 
    }

    public function store(StoreReservationRequest $request): JsonResponse {
        try {
            $this->reservationService->reservation(ReservationDto::from($request->all()));
        } catch (\Exception $ex) {
            return response()->json([
                'errors' => $ex->getMessage(),
                'isSuccess' => false
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'body' => 'Az időpont sikeresen lefoglalva!',
            'isSuccess' => true
        ]);
    }
}
