<?php

namespace App\Infrastructure\Http\Controllers;

use App\Domain\Models\Setting\Setting;
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
    }

    public function show(Setting $setting)
    {
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
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
