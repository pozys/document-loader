<?php

declare(strict_types=1);

namespace App\Domain\Models\Documents;

use App\Domain\Models\Documents\ValueObjects\DocumentSummaryAbstract;

abstract class DocumentValidatorAbstract
{
    abstract public function validate(DocumentSummaryAbstract $summary): array;
}
