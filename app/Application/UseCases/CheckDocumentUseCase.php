<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTO\CheckDocumentRequest;
use App\Application\DTO\CheckDocumentResponse;
use App\Domain\Concerns\Services\DocumentSchemaConverter;
use App\Domain\Interfaces\SchemaRepositoryInterface;
use App\Domain\Models\Documents\Document;
use App\Domain\Models\DTO\SaveDocumentDto;
use App\Domain\Models\Interfaces\DocumentRepositoryInterface;
use App\Infrastructure\Utils\SpreadsheetProcessor;

class CheckDocumentUseCase
{
    public function __construct(
        private readonly SpreadsheetProcessor $processor,
        private readonly SchemaRepositoryInterface $schemaProvider,
        private readonly DocumentSchemaConverter $converter,
        private readonly DocumentRepositoryInterface $repository,
    ) {
    }

    public function execute(CheckDocumentRequest $request): CheckDocumentResponse
    {
        $setting = $request->setting;
        $schema = $this->schemaProvider->getByMeta($setting->document_type, $setting->document_format);
        $documentSchema = $this->converter->toDocumentSchema($schema);

        $parsedDocument = $this->processor->readBySettings(
            $request->documentPath,
            $request->setting,
            ...$documentSchema->getElements()
        );

        $errors = $this->validateDocument($parsedDocument);

        $documentDto = new SaveDocumentDto($setting, $documentSchema, $parsedDocument, $errors);
        $document = $this->repository->create($documentDto);

        return $this->createResponse($document);
    }

    private function validateDocument(array $document): array
    {
        return [];
    }

    private function createResponse(Document $document): CheckDocumentResponse
    {
        $response = new CheckDocumentResponse($document->content, ...$document->errors);

        return $response;
    }
}
