<?php

declare(strict_types=1);

namespace App\Domain\Models\Setting\ValueObjects;

use App\Domain\Models\Casts\DocumentSettings;
use Illuminate\Contracts\Database\Eloquent\Castable;

class Settings implements Castable
{
    public static function castUsing(array $arguments): string
    {
        return DocumentSettings::class;
    }
}
