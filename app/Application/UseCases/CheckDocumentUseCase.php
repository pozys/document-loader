<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTO\CheckDocumentRequest;
use App\Application\DTO\CheckDocumentResponse;
use App\Application\Interfaces\DocumentProcessorInterface;
use App\Domain\Concerns\Services\DocumentSchemaConverter;
use App\Domain\Interfaces\SchemaRepositoryInterface;
use App\Domain\Models\Documents\Document;

class CheckDocumentUseCase
{
    public function __construct(
        // private readonly DocumentProcessorInterface $processor,
        private readonly SchemaRepositoryInterface $schemaProvider,
        private readonly DocumentSchemaConverter $converter,
    ) {
    }

    public function execute(CheckDocumentRequest $request): void
    {
        $settings = $request->setting;
        $schema = $this->schemaProvider->getByMeta($settings->documentType, $settings->documentFormat);
        $documentSchema = $this->converter->toDocumentSchema($schema);
        // $document = $this->processor->read($request->path, $documentSchema);
    }

    private function validateDocument(Document $document): array
    {
        # code...
    }

    private function createResponse(...$validationErrors): CheckDocumentResponse
    {
        # code...
    }
}
