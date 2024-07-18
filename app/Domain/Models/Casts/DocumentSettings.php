<?php

declare(strict_types=1);

namespace App\Domain\Models\Casts;

use App\Domain\Models\Setting\Setting;

class DocumentSettings
{
    public function set(Setting $model, string $key, array $value, array $attributes): void
    {
        # code...
    }
}
