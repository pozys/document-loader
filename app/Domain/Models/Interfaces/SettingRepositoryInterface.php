<?php

declare(strict_types=1);

namespace App\Domain\Models\Interfaces;

use App\Domain\Models\Documents\Document;
use App\Domain\Models\DTO\SaveDocumentDto;
use App\Domain\Models\Setting\Setting;
use Illuminate\Database\Eloquent\Collection;

interface SettingRepositoryInterface
{
    public function get(int $id): Setting;
    public function all(): Collection;
    // public function create(SaveDocumentDto $document): Setting;
    // public function update(int $id, SaveDocumentDto $document): Setting;
}
