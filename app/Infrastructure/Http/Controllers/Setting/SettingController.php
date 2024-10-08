<?php

namespace App\Infrastructure\Http\Controllers\Setting;

use App\Application\DTO\SaveSettingRequest;
use App\Application\UseCases\{StoreSettingUseCase, UpdateSettingUseCase};
use App\Domain\Concerns\Services\DocumentSchemaConverter;
use App\Domain\Enums\DocumentTypes;
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
        private readonly SchemaRepositoryInterface $schemaProvider,
        private readonly DocumentSchemaConverter $converter,
    ) {
    }

    public function index(SettingRepositoryInterface $repository): View
    {
        $settings = $repository->all();

        return view('settings.index', compact('settings'));
    }

    public function create(): View
    {
        return view('settings.create', ['type' => DocumentTypes::UTD]);
    }

    public function store(StoreSettingRequest $request, StoreSettingUseCase $storeSettingUseCase): RedirectResponse
    {
        $storeSettingUseCase->execute($this->makeSaveSettingDtoFromRequest($request));

        return redirect()->route('settings.index');
    }

    public function show(Setting $setting): View
    {
        return view('settings.show', compact('setting'));
    }

    public function edit(Setting $setting): View
    {
        $settings = collect($setting->settings->getSettings())
            ->mapWithKeys(fn ($setting, $name) => [$name => $setting->getValue()])->all();

        return view('settings.edit', compact('setting', 'settings'));
    }

    public function update(
        StoreSettingRequest $request,
        Setting $setting,
        UpdateSettingUseCase $updateSettingUseCase
    ): RedirectResponse {
        $updateSettingUseCase->execute($setting->id, $this->makeSaveSettingDtoFromRequest($request, $setting));

        return redirect()->route('settings.index');
    }

    private function makeSaveSettingDtoFromRequest(
        StoreSettingRequest $request,
    ): SaveSettingRequest {
        $validated = $request->validated();

        return new SaveSettingRequest(
            $validated['name'],
            $validated['document_type'],
            $validated['document_format'],
            $validated['user_id'],
            $validated['settings'],
        );
    }
}
