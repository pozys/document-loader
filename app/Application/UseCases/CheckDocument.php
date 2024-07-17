<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTO\CheckDocumentRequest;
use App\Application\DTO\CheckDocumentResponse;
use App\Application\Interfaces\DocumentProcessorInterface;
use App\Domain\Interfaces\SchemaProviderInterface;
use App\Domain\Models\Documents\Document;

class CheckDocument
{
    public function __construct(
        private readonly DocumentProcessorInterface $processor,
        private readonly SchemaProviderInterface $schemaProvider
    ) {
    }

    public function execute(CheckDocumentRequest $request): void
    {
        $schema = $this->schemaProvider->getByMeta($request->type, $request->format);
        $document = $this->processor->read($request->path, $schema);
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
