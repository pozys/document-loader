<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Domain\Concerns\Enums\SchemaComponentTypes;
use App\Domain\Concerns\Services\DocumentSchemaConverter;
use App\Domain\Enums\{DocumentFormats, DocumentTypes};
use App\Domain\Interfaces\SchemaRepositoryInterface;
use Illuminate\View\View;

class SettingFormComposer
{
    public function __construct(
        private readonly SchemaRepositoryInterface $schemaProvider,
        private readonly DocumentSchemaConverter $converter,
    ) {
    }

    public function compose(View $view): void
    {
        $documentTypes = collect(DocumentTypes::cases())
            ->mapWithKeys(
                fn (DocumentTypes $type) => [$type->value => __("enums.document_types.{$type->value}")]
            );

        $documentFormats = collect(DocumentFormats::cases())
            ->mapWithKeys(
                fn (DocumentFormats $format) => [$format->value => __("enums.document_formats.{$format->value}")]
            );

        $documentSchema = $this->schemaProvider->getByMeta(DocumentTypes::UTD, DocumentFormats::Spreadsheet);
        $schemaElements = collect($this->converter->toArray($documentSchema))
            ->map(function (SchemaComponentTypes $type) {
                return match ($type) {
                    SchemaComponentTypes::String => 'text',
                    SchemaComponentTypes::Integer, SchemaComponentTypes::Float => 'number',
                    default => throw new \InvalidArgumentException('Unsupported schema component type'),
                };
            })->all();

        $view->with(compact('documentTypes', 'documentFormats', 'schemaElements'));
    }
}
