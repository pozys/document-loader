<?php

namespace Database\Factories;

use App\Domain\Enums\{DocumentFormats, DocumentTypes};
use App\Domain\Models\Setting\Setting;
use App\Domain\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
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
}
