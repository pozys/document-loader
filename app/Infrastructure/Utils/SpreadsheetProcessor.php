<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils;

use App\Domain\Concerns\Models\SchemaComponents\AbstractSchemaComponent;
use App\Domain\Models\Setting\Setting;
use App\Infrastructure\Utils\Iterators\SpreadsheetIterator\Iterator;
use App\Infrastructure\Utils\Iterators\SpreadsheetIterator\ScanIteratorMode;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class SpreadsheetProcessor
{
    public function loadFile(string $path): Spreadsheet
    {
        return IOFactory::load($path);
    }

    public function readBySettings(string $path, Setting $setting, AbstractSchemaComponent ...$schemaElements): array
    {
        $spreadsheet = $this->loadFile($path);
        $worksheet = $spreadsheet->getActiveSheet();

        $result = [];

        $iterator = new Iterator($worksheet, new ScanIteratorMode());
        foreach ($schemaElements as $element) {
            $found = $iterator->find($element, $setting);
            if (!$found) {
                throw new \RuntimeException('Nothing is found for setting ' . $setting);
            }

            $result = [...$result, ...$found];

            $iterator->changeMode(new ScanIteratorMode());
        }

        return $result;
    }
}
