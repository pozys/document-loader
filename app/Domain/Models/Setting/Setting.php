<?php

declare(strict_types=1);

namespace App\Domain\Models\Setting;

use App\Domain\Models\Setting\ValueObjects\Settings;
use App\Infrastructure\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'document_type', 'user_id', 'settings'];
    protected $casts = [
        'settings' => Settings::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
