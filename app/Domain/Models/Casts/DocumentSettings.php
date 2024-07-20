<?php

declare(strict_types=1);

namespace App\Domain\Models\Casts;

use App\Domain\Factories\SettingValueFactory;
use App\Domain\Models\Setting\Setting;
use App\Domain\Models\Setting\ValueObjects\Settings;

class DocumentSettings
{
    public function get(Setting $model, string $key, mixed $value, array $attributes): Settings
    {
        $settings = new Settings();
        $rawSettings = json_decode($value, true, 512, JSON_THROW_ON_ERROR);

        foreach ($rawSettings as $key => $item) {
            $settingValue = SettingValueFactory::make(
                $model->getAttributeValue('document_format'),
                $item
            );

            $settings->add($key, $settingValue);
        }

        return $settings;
    }

    public function set(Setting $model, string $key, mixed $value, array $attributes): array
    {
        $this->validate($value);

        return ['settings' => json_encode($value, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT)];
    }

    private function validate(mixed $value): void
    {
        // TODO: validate settings
    }
}
