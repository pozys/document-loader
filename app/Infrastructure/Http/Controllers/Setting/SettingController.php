<?php

namespace App\Infrastructure\Http\Controllers\Setting;

use App\Application\DTO\StoreSettingRequest as StoreSettingDTO;
use App\Application\UseCases\StoreSettingUseCase;
use App\Domain\Concerns\Enums\SchemaComponentTypes;
use App\Domain\Concerns\Services\DocumentSchemaConverter;
use App\Domain\Enums\{DocumentFormats, DocumentTypes};
use App\Domain\Interfaces\SchemaRepositoryInterface;
use App\Domain\Models\Interfaces\SettingRepositoryInterface;
use App\Domain\Models\Setting\Setting;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\StoreSettingRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function __construct(
        private readonly SettingRepositoryInterface $repository,
        private readonly SchemaRepositoryInterface $schemaProvider,
        private readonly DocumentSchemaConverter $converter,
        private readonly StoreSettingUseCase $storeSettingUseCase
    ) {
    }

    public function index(): View
    {
        $settings = $this->repository->all();

        return view('settings.index', compact('settings'));
    }

    public function create(): View
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
        $type = DocumentTypes::UTD;

        return view('settings.create', compact('documentTypes', 'documentFormats', 'schemaElements', 'type'));
    }

    public function store(StoreSettingRequest $request): RedirectResponse
    {
        $this->storeSettingUseCase->execute($this->makeStoreSettingDtoFromRequest($request));

        return redirect()->route('settings.index');
    }

    public function show(Setting $setting): View
    {
        return view('settings.show', compact('setting'));
    }

    public function edit(Setting $setting): View
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
        $settings = collect($setting->settings->getSettings())
            ->mapWithKeys(fn ($setting, $name) => [$name => $setting->getValue()])->all();

        return view(
            'settings.edit',
            compact('documentTypes', 'documentFormats', 'setting', 'settings', 'schemaElements')
        );
    }

    public function update(StoreSettingRequest $request, Setting $setting): RedirectResponse
    {
        $this->storeSettingUseCase->execute($this->makeStoreSettingDtoFromRequest($request, $setting));

        return redirect()->route('settings.index');
    }

    private function makeStoreSettingDtoFromRequest(
        StoreSettingRequest $request,
        ?Setting $setting = null
    ): StoreSettingDTO {
        $validated = $request->validated();

        return new StoreSettingDTO(
            $validated['name'],
            $validated['document_type'],
            $validated['document_format'],
            $validated['user_id'],
            $validated['settings'],
            $setting
        );
    }
}
