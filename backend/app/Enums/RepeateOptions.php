<?php

declare(strict_types=1);

namespace App\Enums;

enum RepeateOptions: string {
    case NEVER = 'NEVER';
    case EVERYWEEK = 'EVERYWEEK';
    case EVENWEEKS = 'EVENWEEKS';
    case ODDWEEKS = 'ODDWEEKS';
}