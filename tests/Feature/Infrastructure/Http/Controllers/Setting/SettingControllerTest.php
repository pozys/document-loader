<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Http\Controllers\Setting;

use App\Domain\Enums\DocumentFormats;
use App\Domain\Enums\DocumentTypes;
use App\Domain\Models\Setting\Setting;
use App\Domain\Models\User\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

class SettingControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::factory(10)->withEmptySettings()->create();

        $this->user = User::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.index'));

        $response->assertOk()
            ->assertViewIs('settings.index')
            ->assertViewHas('settings', fn ($settings) => $settings->count() === 10);
    }

    public function testIndexWithNoData(): void
    {
        Setting::truncate();

        $response = $this->actingAs($this->user)->get(route('settings.index'));

        $response->assertOk()
            ->assertViewIs('settings.index')
            ->assertViewHas('settings', fn ($settings) => $settings->isEmpty());
    }

    public function testShowWithValidSettingId(): void
    {
        $setting = Setting::first();

        $response = $this->actingAs($this->user)->get(route('settings.show', $setting->id));

        $response->assertOk()
            ->assertViewIs('settings.show')
            ->assertViewHas('setting', fn ($viewSetting) => $viewSetting->name === $setting->name);
    }

    public function testShowWithInvalidSettingId(): void
    {
        $invalidSettingId = 9999;

        $response = $this->actingAs($this->user)->get(route('settings.show', $invalidSettingId));

        $response->assertNotFound();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('settings.create'));

        $response->assertOk()->assertViewIs('settings.create');
    }

    public function testStoreWithValidData(): void
    {
        Setting::truncate();

        $requestData = [
            'name' => 'New Setting',
            'document_type' => DocumentTypes::UTD->value,
            'document_format' => DocumentFormats::Spreadsheet->value,
            'user_id' => 1,
            'settings' => [
                'name1' => ['value' => 10],
                'name2' => ['value' => 'value2']
            ],
        ];

        $response = $this->actingAs($this->user)->post(route('settings.store'), $requestData);

        $this->assertDatabaseHas(
            'settings',
            Arr::only($requestData, ['name', 'document_type', 'document_format', 'user_id'])
        );

        $response->assertRedirect(route('settings.index'));
    }

    public function testUpdateWithValidDataAndSettingId(): void
    {
        $setting = Setting::first();
        $requestData = [
            'name' => 'Updated Setting',
            'document_type' => DocumentTypes::UTD->value,
            'document_format' => DocumentFormats::Spreadsheet->value,
            'user_id' => $this->user->id,
            'settings' => [
                'name1' => ['value' => 10],
                'name2' => ['value' => 'value2']
            ],
        ];

        $response = $this->actingAs($this->user)
            ->put(route('settings.update', $setting->id), $requestData);

        $response->assertRedirect(route('settings.index'));

        $updatedSetting = Setting::find($setting->id);

        $this->assertEquals($requestData['name'], $updatedSetting->name);
        $this->assertEquals($requestData['document_type'], $updatedSetting->document_type->value);
        $this->assertEquals($requestData['document_format'], $updatedSetting->document_format->value);
        $this->assertEquals($requestData['user_id'], $updatedSetting->user_id);
    }
}
