<?php

declare(strict_types=1);

namespace App\Domain\Models\Interfaces;

use App\Domain\Models\Documents\Document;
use App\Domain\Models\DTO\SaveDocumentDto;

interface DocumentRepositoryInterface
{
    public function get(int $id): Document;
    public function create(SaveDocumentDto $document): Document;
    public function update(int $id, SaveDocumentDto $document): Document;
}
