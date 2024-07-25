<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils\Iterators\SpreadsheetIterator;

use App\Domain\Concerns\Enums\TriggerPositions;
use App\Domain\Concerns\Models\SchemaComponents\AbstractSchemaComponent;
use App\Domain\Models\Setting\Setting;

class ScanIteratorMode extends IteratorMode
{
    public function find(AbstractSchemaComponent $element, Setting $setting): array
    {
        $trigger = $element->getTrigger();

        while ($this->iterator->next()) {
            $value = $this->iterator->current();

            if ($value !== $trigger->text) {
                continue;
            }

            if ($trigger->position === TriggerPositions::Before) {
                $this->iterator->toNextRow();
            }

            $this->iterator->changeMode(new SearchIteratorMode());

            $found = $this->iterator->find($element, $setting, $trigger);

            $this->iterator->toNextRow();

            return $found;
        }

        return [];
    }
}
