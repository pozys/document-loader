<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Models\ValueObjects;

use App\Domain\Concerns\Enums\TriggerPositions;

class Trigger
{
    readonly public string $text;
    readonly public TriggerPositions $position;

    public function __construct(string $text, string $position)
    {
        $this->validate($text, $position);

        $this->text = $text;
        $this->position = TriggerPositions::from($position);
    }

    private function validate(string $text, string $position): void
    {
        if ($text === '') {
            // TODO: throw exception
            throw new \InvalidArgumentException('Trigger text cannot be empty');
        }

        $position = TriggerPositions::tryFrom($position);

        if ($position === null) {
            // TODO: throw exception
            throw new \InvalidArgumentException('Invalid trigger position');
        }
    }
}
