<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers\Utils;

use App\Domain\Models\Setting\Setting;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SpreadsheetProcessor
{
    public function __construct(private IOFactory $reader)
    {
    }

    public function loadFile(string $path): void
    {
        $this->reader->load($path);
    }

    public function readBySettings(Setting $setting, $file): void
    {
        # code...
    }
}
