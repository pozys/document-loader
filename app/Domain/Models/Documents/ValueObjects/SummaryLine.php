<?php

declare(strict_types=1);

namespace App\Domain\Models\Documents\ValueObjects;

class SummaryLine
{
    public function __construct(public readonly string $parameter, public readonly float|int|string $value)
    {
    }
}
