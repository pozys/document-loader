<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories\DocumentSchema;

use App\Domain\Concerns\Models\DocumentSchema;
use App\Domain\Concerns\Services\DocumentSchemaConverter;
use App\Domain\Enums\DocumentTypes;
use App\Domain\Interfaces\SchemaRepositoryInterface;
use App\Infrastructure\Utils\YamlParser;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Exception\ParseException;

class FileSchemaRepository implements SchemaRepositoryInterface
{
    private string $schemaCatalog;

    public function __construct(private YamlParser $parser, private readonly DocumentSchemaConverter $converter)
    {
        $schemaCatalog = env('SCHEMA_CATALOG');

        if (!$schemaCatalog) {
            // TODO: throw exception
            throw new \Exception('SCHEMA_CATALOG env variable is not set');
        }

        $this->schemaCatalog = storage_path($schemaCatalog);
    }

    public function getByMeta(DocumentTypes $type): DocumentSchema
    {
        $file = $this->find($type);

        $schema = $this->parser->parseFile($file);

        return $this->convertToDocumentSchema($schema);
    }

    private function find(DocumentTypes $type): string
    {
        $file = $this->findByFileName($type->value);

        if (!$file) {
            $file = $this->findByType($type->value);
        }

        if (!$file) {
            // TODO: throw exception
            throw new \Exception('File not found');
        }

        return $file;
    }

    private function findByFileName(string $name): string
    {
        foreach ($this->getFiles() as $file) {
            if (strtolower($file->getFilenameWithoutExtension()) === strtolower($name)) {
                return $file->getPathname();
            }
        }

        return '';
    }

    private function findByType(string $type): string
    {
        foreach ($this->getFiles() as $file) {
            try {
                $yaml = $this->parser->parseFile($file->getPathname());
            } catch (ParseException) {
                continue;
            }

            if (strtolower(data_get($yaml, 'meta.type', '')) === strtolower($type)) {
                return $file->getPathname();
            }
        }

        return '';
    }

    private function getFiles(): array
    {
        return File::files($this->schemaCatalog);
    }

    private function convertToDocumentSchema(array $raw): DocumentSchema
    {
        return $documentSchema = $this->converter->toDocumentSchema($raw);
    }
}
