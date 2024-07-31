<?php

declare(strict_types=1);

namespace App\Domain\Models\Setting;

use App\Domain\Enums\{DocumentFormats, DocumentTypes};
use App\Domain\Models\Casts\DocumentSettings;
use App\Domain\Models\User\User;
use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Factories\{Factory, HasFactory};
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'document_type',
        'document_format',
        'user_id',
    ];

    protected $casts = [
        'document_type' => DocumentTypes::class,
        'document_format' => DocumentFormats::class,
        'settings' => DocumentSettings::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSetting(string $name): mixed
    {
        return $this->settings->getSetting($name);
    }

    protected static function newFactory(): Factory
    {
        return SettingFactory::new();
    }
}
