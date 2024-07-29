<?php

declare(strict_types=1);

namespace App\Domain\Models\Interfaces;

use App\Domain\Models\Documents\Document;
use App\Domain\DTO\SaveDocumentDto;
use Illuminate\Database\Eloquent\Collection;

interface DocumentRepositoryInterface
{
    public function get(int $id): Document;
    public function all(): Collection;
    public function store(SaveDocumentDto $document): Document;
    public function update(int $id, SaveDocumentDto $document): Document;
}
