<?php

declare(strict_types=1);

namespace App\Domain\Models\Interfaces;

use App\Application\DTO\SaveSettingRequest;
use App\Domain\Models\Setting\Setting;
use Illuminate\Database\Eloquent\Collection;

interface SettingRepositoryInterface
{
    public function get(int $id): Setting;
    public function all(): Collection;
    public function store(SaveSettingRequest $setting): Setting;
    public function update(int $id, SaveSettingRequest $setting): Setting;
}
