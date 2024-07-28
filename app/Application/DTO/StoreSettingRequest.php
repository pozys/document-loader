<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Models\Setting\Setting;

class StoreSettingRequest
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $format,
        public readonly int $user_id,
        public readonly array $settings,
        public readonly ?Setting $setting = null,
    ) {
    }
}
