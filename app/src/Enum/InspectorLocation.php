<?php

declare(strict_types=1);

namespace App\Enum;

enum InspectorLocation: string {
    case LONDON = 'Europe/London';
    case MEXICO = 'America/Mexico_City';
    case INDIA = 'Asia/Kolkata';
    case NEW_YORK = 'America/New_York';
    case AUSTRALIA = 'Australia/Sydney';
}
