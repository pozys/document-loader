<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Models;

use App\Domain\Enums\DocumentFormats;
use App\Domain\Enums\DocumentTypes;

class DocumentSchema
{
    private DocumentTypes $documentType;
    private DocumentFormats $documentFormat;
}
