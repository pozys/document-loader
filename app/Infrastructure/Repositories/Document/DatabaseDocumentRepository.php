<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories\Document;

use App\Domain\Models\Documents\Document;
use App\Domain\DTO\SaveDocumentDto;
use App\Domain\Models\Interfaces\DocumentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class DatabaseDocumentRepository implements DocumentRepositoryInterface
{
    public function get(int $id): Document
    {
        return Document::findOrFail($id);
    }

    public function all(): Collection
    {
        return Document::all();
    }

    public function store(SaveDocumentDto $data): Document
    {
        $document = app(Document::class);
        $document = $this->fill($document, $data);
        $document->save();

        $document->refresh();

        return $document;
    }

    public function update(int $id, SaveDocumentDto $data): Document
    {
        $document = $this->get($id);
        $document = $this->fill($document, $data);
        $document->save();

        $document->refresh();

        return $document;
    }

    private function fill(Document $document, SaveDocumentDto $data): Document
    {
        $document->settings = $data->setting->toJson();
        $document->schema = json_encode($data->schema->getElements(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        $document->content = $data->content;
        $document->errors = $data->errors;
        $document->author_id = Auth::id();

        return $document;
    }
}
