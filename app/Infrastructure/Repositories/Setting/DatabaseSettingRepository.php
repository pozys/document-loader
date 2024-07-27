<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories\Setting;

use App\Domain\Models\Interfaces\SettingRepositoryInterface;
use App\Domain\Models\Setting\Setting;
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
}
