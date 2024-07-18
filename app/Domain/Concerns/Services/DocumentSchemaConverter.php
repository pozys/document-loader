<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Services;

use App\Domain\Concerns\Models\DocumentSchema;
use App\Domain\Enums\DocumentTypes;
use App\Domain\Factories\SchemaComponentFactory;

class DocumentSchemaConverter
{
    public function __construct(private SchemaComponentFactory $schemaComponentFactory)
    {
    }

    public function toDocumentSchema(array $data): DocumentSchema
    {
        $meta = $this->provideMeta($data);
        $type = data_get($meta, 'type', '');
        $documentType = DocumentTypes::tryFrom($type);

        if ($documentType === null) {
            // TODO: throw exception
            throw new \InvalidArgumentException("Invalid type - '$type' - provided for document schema");
        }

        $documentSchema = new DocumentSchema();
        $documentSchema = $documentSchema->setDocumentType($documentType);

        $schema = $this->provideSchema($data);
        foreach ($schema as $key => $value) {
            $component = $this->schemaComponentFactory->make($key, $value);
            $documentSchema = $documentSchema->add($component);
        }

        return $documentSchema;
    }

    private function provideMeta(array $data): array
    {
        if (!(array_key_exists('meta', $data) && is_array($data['meta']))) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No meta provided for document schema');
        }

        return $data['meta'];
    }

    private function provideSchema(array $data): array
    {
        if (!(array_key_exists('schema', $data) && is_array($data['schema']))) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No schema provided for document schema');
        }

        return $data['schema'];
    }
}
