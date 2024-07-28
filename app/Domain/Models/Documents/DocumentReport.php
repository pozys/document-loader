<?php

declare(strict_types=1);

namespace App\Domain\Models\Documents;

use App\Domain\Models\Documents\ValueObjects\DocumentSummaryAbstract;
use App\Domain\Models\Documents\ValueObjects\ValidationError;

class DocumentReport
{
    public readonly array $errors;

    public function __construct(
        public readonly DocumentSummaryAbstract $summary,
        ?ValidationError ...$errors,
    ) {
        $this->errors = $errors;
    }
}
