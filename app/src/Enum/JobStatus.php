<?php

declare(strict_types=1);

namespace App\Enum;

enum JobStatus: string {
    case NEW = 'new';
    case ASSIGNED = 'assigned';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}
