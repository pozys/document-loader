<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Domain\Enums\DocumentTypes;

interface SchemaProviderInterface
{
    public function getByMeta(DocumentTypes $type): array;
}
