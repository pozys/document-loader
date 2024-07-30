<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils\Iterators\SpreadsheetIterator;

use App\Domain\Interfaces\Structuring;
use App\Domain\Models\Setting\Setting;

class CollectionSearchIteratorMode extends AbstractSearchIteratorMode
{
    public function find(Structuring $schemaElement, Setting $setting): array
    {
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
