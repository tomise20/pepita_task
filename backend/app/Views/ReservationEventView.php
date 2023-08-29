<?php

declare(strict_types=1);

namespace App\Views;

final class ReservationEventView {

    function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $start,
        public readonly ?string $end
    )
    {    
    } 
}
