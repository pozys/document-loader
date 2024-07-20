<?php

declare(strict_types=1);

namespace App\Domain\Models\Setting\ValueObjects;

use App\Domain\Models\Casts\DocumentSettings;
use Illuminate\Contracts\Database\Eloquent\Castable;

class Settings implements Castable
{
    private array $settings = [];

    public function add(string $name, $value)
    {
        $this->settings[$name] = $value;
    }

    public static function castUsing(array $arguments): string
    {
        return DocumentSettings::class;
    }

    public function getSetting(string $name): mixed
    {
        return $this->settings[$name] ?? null;
    }
}
