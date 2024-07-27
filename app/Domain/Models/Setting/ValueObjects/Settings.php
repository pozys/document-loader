<?php

declare(strict_types=1);

namespace App\Domain\Models\Setting\ValueObjects;

use App\Domain\Enums\DocumentFormats;
use App\Domain\Factories\SettingValueFactory;
use App\Domain\Interfaces\SettingValueInterface;
use JsonSerializable;

class Settings implements JsonSerializable
{
    private array $settings = [];

    public function __construct(array $data, DocumentFormats $format)
    {
        foreach ($data as $key => $item) {
            $settingValue = SettingValueFactory::make($format, $item);
            $this->add($key, $settingValue);
        }
    }

    public function jsonSerialize(): mixed
    {
        return json_encode($this->settings, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function getSetting(string $name): mixed
    {
        return $this->settings[$name] ?? null;
    }

    private function add(string $name, SettingValueInterface $value)
    {
        $this->settings[$name] = $value;
    }
}
