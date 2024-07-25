<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils\Iterators\SpreadsheetIterator;

use App\Domain\Concerns\Models\SchemaComponents\AbstractSchemaComponent;
use App\Domain\Concerns\Models\SchemaComponents\Collection;
use App\Domain\Concerns\Models\SchemaComponents\Primitive;
use App\Domain\Concerns\Models\SchemaComponents\Row;
use App\Domain\Models\Setting\Setting;
use Illuminate\Support\Arr;

class SearchIteratorMode extends IteratorMode
{
    public function find(AbstractSchemaComponent $schemaElement, Setting $setting): array
    {
        if ($schemaElement instanceof Row) {
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
        } elseif ($schemaElement instanceof Collection) {
            $collectionName = $schemaElement->getName();
            $result = [$collectionName => []];

            while (true) {
                $row = [];

                foreach ($schemaElement->getProperties() as $property) {
                    $name = $property->getName();
                    $settings = $setting->getSetting("{$collectionName}.{$name}");

                    if (!$settings) {
                        // TODO: throw exception
                        throw new \InvalidArgumentException("Setting for property '$name' not found");
                    }

                    $this->iterator->jumpToColumn($settings->getValue());
                    $value = $this->iterator->current();

                    if ((!$value || $this->iterator->isNullValue()) && $property->isControl()) {
                        $row = [];
                        break;
                    }

                    while ((!$value || $this->iterator->isNullValue()) && $result === []) {
                        $this->iterator->toNextRow();
                        $this->iterator->jumpToColumn($settings->getValue());
                        $value = $this->iterator->current();
                    }

                    $row[$name] = $value;
                }

                if ($row === []) {
                    break;
                }

                $result[$collectionName][] = $row;
                $this->iterator->toNextRow();
            }

            return $result;
        }
    }
}
