<?php

declare(strict_types=1);

namespace App\Domain\Models\Casts;

use App\Domain\Models\Setting\ValueObjects\Settings;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DocumentSettings implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): Settings
    {
        return new Settings(
            json_decode($value, true, 512, JSON_THROW_ON_ERROR),
            $model->document_format
        );
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        $this->validate($value);

        return $value->jsonSerialize();
    }

    private function validate(mixed $value): void
    {
        // TODO: validate settings
        if (!$value instanceof Settings) {
            throw new \InvalidArgumentException('Value must be instance of Settings');
        }
    }
}
