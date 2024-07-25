<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils\Iterators\SpreadsheetIterator;

use App\Domain\Concerns\Models\SchemaComponents\AbstractSchemaComponent;
use App\Domain\Models\Setting\Setting;

abstract class IteratorMode
{
    protected Iterator $iterator;

    public function setIterator(Iterator $iterator): void
    {
        $this->iterator = $iterator;
    }

    abstract public function find(AbstractSchemaComponent $element, Setting $setting): array;
}
