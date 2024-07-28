<?php

declare(strict_types=1);

namespace App\Domain\Models\Documents;

use App\Domain\DTO\ParsedDocumentDto;
use App\Domain\Models\Documents\ValueObjects\DocumentSummaryAbstract;

abstract class DocumentSummaryProviderAbstract
{
    abstract public function summarizeDocument(ParsedDocumentDto $document): DocumentSummaryAbstract;
}
