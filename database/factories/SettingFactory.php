<?php

namespace Database\Factories;

use App\Domain\Enums\{DocumentFormats, DocumentTypes};
use App\Domain\Models\Setting\Setting;
use App\Domain\Models\Setting\ValueObjects\Settings;
use App\Domain\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'document_type' => DocumentTypes::UTD,
            'document_format' => DocumentFormats::Spreadsheet,
            'user_id' => User::factory(),
        ];
    }

    public function withEmptySettings(): self
    {
        return $this->state(
            fn (array $attributes) => ['settings' => new Settings([], $attributes['document_format'])]
        );
    }
}
