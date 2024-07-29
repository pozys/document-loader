<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\Models\Documents\Document;
use Illuminate\Http\Client\Response;

interface DocumentLoaderInterface
{
    public function sendDocument(Document $document): Response;
}
