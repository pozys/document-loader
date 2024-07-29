<?php

declare(strict_types=1);

namespace App\Application\DTO;

class SaveSettingRequest
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $format,
        public readonly int $user_id,
        public readonly array $settings,
    ) {
    }
}
