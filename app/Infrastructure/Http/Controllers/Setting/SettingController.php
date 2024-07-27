<?php

namespace App\Infrastructure\Http\Controllers\Setting;

use App\Domain\Enums\DocumentFormats;
use App\Domain\Enums\DocumentTypes;
use App\Domain\Models\Interfaces\SettingRepositoryInterface;
use App\Domain\Models\Setting\Setting;
use App\Domain\Models\Setting\ValueObjects\Settings;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\StoreSettingRequest;
use App\Infrastructure\Http\Requests\UpdateSettingRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function __construct(public readonly SettingRepositoryInterface $repository)
    {
    }

    public function index(): View
    {
        $settings = $this->repository->all();

        return view('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $settingValues = $setting->settings->getSettings();

        return view('settings.edit', compact('documentTypes', 'documentFormats', 'setting', 'settingValues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSettingRequest $request, Setting $setting): RedirectResponse
    {
        $setting->fill($request->validated());
        $setting->settings = new Settings($request->settings, $setting->document_format);
        $setting->save();

        return redirect()->route('settings.index');
    }
}
