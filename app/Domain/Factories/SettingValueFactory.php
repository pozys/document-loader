<?php

declare(strict_types=1);

namespace App\Domain\Factories;

use App\Domain\Enums\DocumentFormats;
use App\Domain\Interfaces\SettingValueInterface;
use App\Domain\Models\Setting\ValueObjects\SpreadsheetAddress;

class SettingValueFactory
{
    public static function make(DocumentFormats $format, array $data): SettingValueInterface
    {
        return match ($format) {
            DocumentFormats::Spreadsheet => new SpreadsheetAddress($data),
            default => throw new \InvalidArgumentException('Unsupported document format'),
        };
    }
}
