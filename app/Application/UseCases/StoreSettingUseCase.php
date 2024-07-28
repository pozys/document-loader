<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTO\StoreSettingRequest;
use App\Domain\Models\Setting\Setting;
use App\Domain\Models\Setting\ValueObjects\Settings;

class StoreSettingUseCase
{
    public function execute(StoreSettingRequest $request): Setting
    {
        $setting = $request->setting ?? app(Setting::class);
        $setting->settings = new Settings($request->settings, $setting->document_format);
        $setting->save();

        return $setting;
    }
}
