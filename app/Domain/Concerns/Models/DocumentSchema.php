<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Models;

use App\Domain\Concerns\Models\SchemaComponents\AbstractSchemaComponent;
use App\Domain\Enums\DocumentTypes;

class DocumentSchema
{
    private DocumentTypes $documentType;
    private array $container = [];

    public function setDocumentType($documentType): self
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function add(AbstractSchemaComponent $component): self
    {
        $this->container[] = $component;

        return $this;
    }

    public function getDocumentType(): DocumentTypes
    {
        return $this->documentType;
    }

    public function getComponents(): array
    {
        return $this->container;
    }
}
