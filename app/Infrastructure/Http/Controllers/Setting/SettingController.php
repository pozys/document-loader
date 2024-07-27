<?php

namespace App\Infrastructure\Http\Controllers\Setting;

use App\Domain\Concerns\Enums\SchemaComponentTypes;
use App\Domain\Concerns\Services\DocumentSchemaConverter;
use App\Domain\Enums\DocumentFormats;
use App\Domain\Enums\DocumentTypes;
use App\Domain\Interfaces\SchemaRepositoryInterface;
use App\Domain\Models\Interfaces\SettingRepositoryInterface;
use App\Domain\Models\Setting\Setting;
use App\Domain\Models\Setting\ValueObjects\Settings;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\StoreSettingRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function __construct(
        private readonly SettingRepositoryInterface $repository,
        private readonly SchemaRepositoryInterface $schemaProvider,
        private readonly DocumentSchemaConverter $converter
    ) {
    }

    public function index(): View
    {
        $settings = $this->repository->all();

        return view('settings.index', compact('settings'));
    }

    public function create(): View
    {
        $documentTypes = [DocumentTypes::UTD->value => DocumentTypes::UTD->value];
        $documentFormats = [DocumentFormats::Spreadsheet->value => DocumentFormats::Spreadsheet->value];
        $documentSchema = $this->schemaProvider->getByMeta(DocumentTypes::UTD, DocumentFormats::Spreadsheet);
        $schemaElements = collect($this->converter->toArray($documentSchema))
            ->map(function (SchemaComponentTypes $type) {
                return match ($type) {
                    SchemaComponentTypes::String => 'text',
                    SchemaComponentTypes::Integer, SchemaComponentTypes::Float => 'number',
                    default => throw new \InvalidArgumentException('Unsupported schema component type'),
                };
            })->all();

        return view('settings.create', compact('documentTypes', 'documentFormats', 'schemaElements'));
    }

    public function store(StoreSettingRequest $request)
    {
        $setting = new Setting();
        $setting->fill($request->validated());
        $setting->settings = new Settings($request->settings, $setting->document_format);
        $setting->save();
    }

    public function show(Setting $setting): View
    {
        return view('settings.show', compact('setting'));
    }

    public function edit(Setting $setting): View
    {
        $documentTypes = [DocumentTypes::UTD->value => DocumentTypes::UTD->value];
        $documentFormats = [DocumentFormats::Spreadsheet->value => DocumentFormats::Spreadsheet->value];
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

        return view('settings.edit', compact('documentTypes', 'documentFormats', 'setting', 'settings', 'schemaElements'));
    }

    public function update(StoreSettingRequest $request, Setting $setting): RedirectResponse
    {
        $setting->fill($request->validated());
        $setting->settings = new Settings($request->settings, $setting->document_format);
        $setting->save();

        return redirect()->route('settings.index');
    }
}
