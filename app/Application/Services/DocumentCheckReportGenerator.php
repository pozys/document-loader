<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\DTO\ParsedDocumentDto;
use App\Domain\Models\Documents\{DocumentReport, DocumentSummaryProviderAbstract, DocumentValidatorAbstract};

class DocumentCheckReportGenerator
{
    public function __construct(
        private readonly DocumentSummaryProviderAbstract $summaryProvider,
        private readonly DocumentValidatorAbstract $validator
    ) {
    }

    public function generate(ParsedDocumentDto $document): DocumentReport
    {
        $summary = $this->summaryProvider->summarizeDocument($document);

        return new DocumentReport($summary, ...$this->validator->validate($summary));
    }
}
