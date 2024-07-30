<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils\Iterators\SpreadsheetIterator;

use App\Domain\Concerns\Models\SchemaComponents\Primitive;
use App\Domain\Interfaces\Structuring;
use App\Domain\Models\Setting\Setting;

class RowSearchIteratorMode extends AbstractSearchIteratorMode
{
    public function find(Structuring $schemaElement, Setting $setting): array
    {
        return collect($schemaElement->getProperties())
            ->mapWithKeys(function (Primitive $property) use ($setting) {
                $name = $property->getName();
                $settings = $setting->getSetting($name);

                if (!$settings) {
                    // TODO: throw exception
                    throw new \InvalidArgumentException("Setting for property '$name' not found");
                }

                $this->iterator->jumpToColumn($settings->getValue());
                $value = $this->iterator->current();

                while (!$value || $this->iterator->isNullValue()) {
                    $this->iterator->toNextRow();
                    $this->iterator->jumpToColumn($settings->getValue());
                    $value = $this->iterator->current();
                }

                return [$name => $value];
            })
            ->all();
    }
}
