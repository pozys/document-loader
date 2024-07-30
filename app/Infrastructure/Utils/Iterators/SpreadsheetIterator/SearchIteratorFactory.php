<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils\Iterators\SpreadsheetIterator;

use App\Domain\Concerns\Models\SchemaComponents\{Collection, Row};
use App\Domain\Interfaces\Structuring;

class SearchIteratorFactory
{
    public static function create(Structuring $element): AbstractSearchIteratorMode
    {
        return match (get_class($element)) {
            Row::class => app(RowSearchIteratorMode::class),
            Collection::class => app(CollectionSearchIteratorMode::class),
            default => throw new \InvalidArgumentException("Unsupported schema element type: " . get_class($element)),
        };
    }
}
