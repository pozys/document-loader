<?php

namespace Tests\Feature;

use App\Domain\Concerns\Enums\SchemaComponentTypes;
use Tests\TestCase;
use App\Domain\Concerns\Services\DocumentSchemaConverter;
use App\Domain\Concerns\Models\DocumentSchema;
use App\Domain\Concerns\Models\SchemaComponents\Row;
use App\Domain\Enums\DocumentFormats;
use App\Domain\Enums\DocumentTypes;
use App\Domain\Factories\SchemaComponentFactory;
use App\Domain\Models\Setting\Setting;
use App\Domain\Models\Setting\ValueObjects\Settings;
use App\Infrastructure\Utils\Iterators\SpreadsheetIterator\Iterator;
use App\Infrastructure\Utils\Iterators\SpreadsheetIterator\ScanIteratorMode;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Tests\Feature\Factories\SameRowElementFactory;

class IteratorTest extends TestCase
{
    private readonly Worksheet $worksheet;
    private readonly Setting $setting;
    private readonly string $sameTriggerText;
    private readonly string $beforeTriggerText;
    private readonly string $collectionTriggerText;
    private readonly string $sameRowValue;
    private readonly string $nextRowValue;
    private readonly string $sameRowSettingName;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sameTriggerText = 'same trigger text';
        $this->beforeTriggerText = 'before trigger text';
        $this->collectionTriggerText = 'collection trigger text';
        $this->sameRowValue = 94;
        $this->nextRowValue = 32;
        $this->sameRowSettingName = 'same_row_name';

        $spreadsheet = new Spreadsheet();
        $this->worksheet = $spreadsheet->getActiveSheet();

        $dataArray = [
            ['skip', 'skip', 'skip', 0],
            ['10', 'Q3', $this->beforeTriggerText, 860],
            ['10', $this->nextRowValue, 'United States', 5850],
            ['skip', 'skip', 'skip', 0],
            ['skip', 'skip', 'skip', 0],
            [$this->collectionTriggerText, 'skip', 'skip', 0],
            [11, 'skip', 13, 0],
            [21, 'skip', 23, 0],
            ['skip', $this->sameTriggerText, 'United States', $this->sameRowValue],
            [21, 'skip', 23, 0],
        ];

        $this->worksheet->fromArray($dataArray, null, 'B2');

        $this->setting = Setting::factory()->make();
        $this->setting->settings = new Settings(
            [$this->sameRowSettingName => ['value' => 5]],
            DocumentFormats::Spreadsheet
        );
    }

    public function testSameRowElement()
    {
        $element = SameRowElementFactory::create($this->sameTriggerText, $this->sameRowSettingName);
        $iterator = new Iterator($this->worksheet, new ScanIteratorMode());

        $found = $iterator->find($element, $this->setting);

        $this->assertCount(1, $found);
        $this->assertEquals($this->sameRowValue, $found[$this->sameRowSettingName]);
    }
}
