<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories\Setting;

use App\Application\DTO\SaveSettingRequest;
use App\Domain\Enums\DocumentFormats;
use App\Domain\Models\Interfaces\SettingRepositoryInterface;
use App\Domain\Models\Setting\Setting;
use App\Domain\Models\Setting\ValueObjects\Settings;
use Illuminate\Database\Eloquent\Collection;

class DatabaseSettingRepository implements SettingRepositoryInterface
{
    public function get(int $id): Setting
    {
        return Setting::findOrFail($id);
    }

    public function all(): Collection
    {
        return Setting::all();
    }

    public function store(SaveSettingRequest $request): Setting
    {
        $setting = app(Setting::class);
        $setting = $this->fillFromRequest($setting, $request);
        $setting->settings = new Settings($request->settings, DocumentFormats::from($request->format));
        $setting->save();

        return $setting;
    }

    public function update(int $id, SaveSettingRequest $request): Setting
    {
        $setting = $this->get($id);
        $setting = $this->fillFromRequest($setting, $request);
        $setting->settings = new Settings($request->settings, $setting->document_format);
        $setting->save();

        return $setting;
    }

    private function fillFromRequest(Setting $setting, SaveSettingRequest $request): Setting
    {
        $setting->name = $request->name;
        $setting->document_type = $request->type;
        $setting->document_format = $request->format;
        $setting->user_id = $request->user_id;

        return $setting;
    }
}
