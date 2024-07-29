<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTO\{CheckDocumentRequest, CheckDocumentResponse};
use App\Application\Interfaces\DocumentProcessorInterface;
use App\Application\Services\DocumentCheckReportGenerator;
use App\Domain\DTO\ParsedDocumentDto;
use App\Domain\Models\Documents\UTD\{UTDSummaryProvider, UTDValidator};
use App\Domain\DTO\SaveDocumentDto;
use App\Domain\Models\Documents\DocumentReport;
use App\Domain\Models\Documents\ValueObjects\{SummaryLine, ValidationError};
use App\Domain\Models\Interfaces\DocumentRepositoryInterface;

class CheckDocumentUseCase
{
    public function __construct(
        private readonly DocumentProcessorInterface $processor,
        private readonly DocumentRepositoryInterface $repository,
    ) {
    }

    public function execute(CheckDocumentRequest $request): CheckDocumentResponse
    {
        $parsedDocument = $this->processor->readBySettings(
            $request->path,
            $request->setting,
            ...$request->documentSchema->getElements()
        );

        $report = $this->provideReport($parsedDocument);

        $documentDto = new SaveDocumentDto(
            $request->setting,
            $request->documentSchema,
            $parsedDocument->content,
            $report->errors
        );

        $document = $this->repository->store($documentDto);

        return $this->createResponse($document->id, $report);
    }

    private function provideReport(ParsedDocumentDto $document): DocumentReport
    {
        $reportGenerator = new DocumentCheckReportGenerator(app(UTDSummaryProvider::class), app(UTDValidator::class));

        return $reportGenerator->generate($document);
    }

    private function createResponse(int $id, DocumentReport $report): CheckDocumentResponse
    {
        $summary = collect($report->summary->getAttributes())
            ->flatten()
            ->mapWithKeys(
                fn (SummaryLine $summaryLine) => [$summaryLine->parameter => $summaryLine->value]
            )->all();

        $errors = collect($report->errors)
            ->mapWithKeys(
                fn (ValidationError $error) => [$error->parameter => $error->message]
            )->all();

        return new CheckDocumentResponse($id, $summary, $errors);
    }
}
