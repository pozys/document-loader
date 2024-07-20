<?php

declare(strict_types=1);

namespace App\Domain\Models\Setting;

use App\Domain\Enums\DocumentFormats;
use App\Domain\Enums\DocumentTypes;
use App\Domain\Models\Setting\ValueObjects\Settings;
use App\Domain\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'settings' => Settings::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSetting(string $name): mixed
    {
        return $this->settings->getSetting($name);
    }
}
