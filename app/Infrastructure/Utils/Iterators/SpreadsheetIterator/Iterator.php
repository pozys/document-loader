<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils\Iterators\SpreadsheetIterator;

use App\Domain\Interfaces\Structuring;
use App\Domain\Models\Setting\Setting;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Iterator
{
    private int $rowNumber = 1;
    private int $columnNumber = 0;
    private int $highestColumnIndex;
    private int $highestRow;

    public function __construct(private Worksheet $worksheet, private IteratorMode $mode)
    {
        $this->highestRow = $worksheet->getHighestDataRow();
        $highestColumn = $worksheet->getHighestDataColumn();
        $this->highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        $this->changeMode($mode);
    }

    public function changeMode(IteratorMode $mode): void
    {
        $this->mode = $mode;
        $this->mode->setIterator($this);
    }

    public function find(Structuring $element, Setting $setting): array
    {
        return $this->mode->find($element, $setting);
    }

    public function current(): mixed
    {
        return $this->worksheet->getCell([$this->columnNumber, $this->rowNumber])->getValue();
    }

    public function next(): bool
    {
        $this->stepForward();

        return $this->isValid();
    }

    public function toNextRow(): void
    {
        $this->rewindColumn();
        $this->rowNumber++;
    }

    public function isValid(): bool
    {
        return $this->rowNumber < $this->highestRow;
    }

    public function jumpToColumn(int $column): void
    {
        $this->columnNumber = $column;
    }

    public function isNullValue(): bool
    {
        return $this->current() === ExcelError::null();
    }

    private function stepForward(): void
    {
        if ($this->nextColumn()) {
            $this->toNextColumn();
            return;
        }

        $this->toNextRow();
    }

    private function toNextColumn(): void
    {
        $this->columnNumber++;
    }

    private function rewindColumn(): void
    {
        $this->columnNumber = 1;
    }

    private function nextColumn(): bool
    {
        return ($this->columnNumber + 1) < $this->highestColumnIndex;
    }
}
