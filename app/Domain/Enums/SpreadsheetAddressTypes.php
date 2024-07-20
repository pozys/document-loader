<?php

declare(strict_types=1);

namespace App\Domain\Enums;

enum SpreadsheetAddressTypes: string
{
    case Cell = 'cell';
    case Column = 'column';
    case Row = 'row';
}
