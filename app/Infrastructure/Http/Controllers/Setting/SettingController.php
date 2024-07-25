<?php

namespace App\Infrastructure\Http\Controllers\Setting;

use App\Domain\Models\Setting\Setting;
use App\Domain\Models\Setting\ValueObjects\Settings;
use App\Infrastructure\Http\Requests\StoreSettingRequest;
use App\Infrastructure\Http\Requests\UpdateSettingRequest;

class SettingController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function show(Setting $setting)
    {
        return $setting;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSettingRequest $request, Setting $setting)
    {
        $setting->fill($request->validated());
        $setting->settings = new Settings($request->settings, $setting->document_format);
        $setting->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
