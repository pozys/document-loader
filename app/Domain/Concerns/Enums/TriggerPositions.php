<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Enums;

enum TriggerPositions: string
{
    case Before = "before";
    case Same = "same";
}
