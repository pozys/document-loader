<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Domain\Concerns\Models\DocumentSchema;
use App\Domain\Enums\DocumentTypes;

interface SchemaRepositoryInterface
{
    public function getByMeta(DocumentTypes $type): DocumentSchema;
}
