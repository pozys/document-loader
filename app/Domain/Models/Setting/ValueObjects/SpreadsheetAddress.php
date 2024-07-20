<?php

declare(strict_types=1);

namespace App\Domain\Models\Setting\ValueObjects;

use App\Domain\Enums\SpreadsheetAddressTypes;
use App\Domain\Interfaces\SettingValueInterface;

final class SpreadsheetAddress implements SettingValueInterface
{
    private ?int $column = null;
    private ?int $row = null;
    private SpreadsheetAddressTypes $addressType;

    public function __construct(array $data)
    {
        $this->addressType = SpreadsheetAddressTypes::tryFrom(data_get($data, 'type'));

        if ($this->addressType === null) {
            // TODO: throw exception
            throw new \Exception('Invalid address type');
        }

        $this->setValue(data_get($data, 'value', []));
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    private function setValue(array $value): void
    {
        match ($this->addressType) {
            SpreadsheetAddressTypes::Column => $this->setColumn(data_get($value, 'column')),
            SpreadsheetAddressTypes::Row => $this->setRow(data_get($value, 'row')),
            SpreadsheetAddressTypes::Cell => $this->setCell(data_get($value, 'column'), data_get($value, 'row')),
            default => throw new \Exception('Invalid address type'),
        };
    }

    private function setColumn(int $column): void
    {
        $this->column = $column;
    }

    private function setRow(int $row): void
    {
        $this->row = $row;
    }

    private function setCell(int $column, int $row): void
    {
        $this->setColumn($column);
        $this->setRow($row);
    }
}
