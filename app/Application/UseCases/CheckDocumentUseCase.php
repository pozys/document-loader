<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTO\{CheckDocumentRequest, CheckDocumentResponse};
use App\Application\Interfaces\DocumentProcessorInterface;
use App\Domain\Models\Documents\Document;
use App\Domain\Models\DTO\SaveDocumentDto;
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

        $errors = $this->validateDocument($parsedDocument);

        $documentDto = new SaveDocumentDto($request->setting, $request->documentSchema, $parsedDocument, $errors);
        $document = $this->repository->create($documentDto);

        return $this->createResponse($document);
    }

    private function validateDocument(array $document): array
    {
        return [];
    }

    private function createResponse(Document $document): CheckDocumentResponse
    {
        $response = new CheckDocumentResponse($document->content, $document->errors);

        return $response;
    }
}
