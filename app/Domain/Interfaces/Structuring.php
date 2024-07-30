<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Domain\Concerns\Models\ValueObjects\Trigger;

interface Structuring
{
    public function getTrigger(): Trigger;

    public function getProperties(): array;
}
