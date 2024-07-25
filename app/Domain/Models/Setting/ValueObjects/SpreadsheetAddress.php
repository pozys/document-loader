<?php

declare(strict_types=1);

namespace App\Domain\Models\Setting\ValueObjects;

use App\Domain\Interfaces\SettingValueInterface;
use JsonSerializable;

final class SpreadsheetAddress implements SettingValueInterface, JsonSerializable
{
    private ?int $column = null;

    public function __construct(array $data)
    {
        $this->setValue(data_get($data, 'value'));
    }

    public function getValue(): int
    {
        return $this->column;
    }

    public function jsonSerialize(): mixed
    {
        return ['value' => $this->getValue()];
    }

    private function setValue(int $value): void
    {
        $this->column = $value;
    }
}
