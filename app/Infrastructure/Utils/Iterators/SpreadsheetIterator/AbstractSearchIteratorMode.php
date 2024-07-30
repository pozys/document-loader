<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils\Iterators\SpreadsheetIterator;

use App\Domain\Interfaces\Structuring;
use App\Domain\Models\Setting\Setting;

abstract class AbstractSearchIteratorMode extends IteratorMode
{
    abstract public function find(Structuring $schemaElement, Setting $setting): array;
}
