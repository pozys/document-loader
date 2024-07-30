<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils;

use App\Application\Interfaces\DocumentLoaderInterface;
use App\Domain\Models\Documents\Document;
use App\Infrastructure\Interfaces\HttpClientInterface;
use Illuminate\Http\Client\Response;

class DocumentLoaderService implements DocumentLoaderInterface
{
    public function __construct(private readonly HttpClientInterface $client)
    {
    }

    public function sendDocument(Document $document): Response
    {
        $endpoint = config('endpoints.document_loader_endpoint');

        return $this->client->setUrl($endpoint)
            ->setBody($document->content)
            ->post();
    }
}
