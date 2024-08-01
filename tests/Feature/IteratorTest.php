<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Domain\Enums\DocumentFormats;
use App\Domain\Models\Setting\Setting;
use App\Domain\Models\Setting\ValueObjects\Settings;
use App\Infrastructure\Utils\Iterators\SpreadsheetIterator\{Iterator, ScanIteratorMode};
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Tests\Feature\Factories\CollectionElementFactory;
use Tests\Feature\Factories\RowElementFactory;

class IteratorTest extends TestCase
{
    private Worksheet $worksheet;
    private Setting $setting;
    private string $sameTriggerText = 'same trigger text';
    private string $beforeTriggerText = 'before trigger text';
    private string $collectionTriggerText = 'collection trigger text';
    private int $sameRowValue = 94;
    private int $nextRowValue = 32;
    private string $sameRowSettingName = 'same_row_name';
    private string $nextRowSettingName = 'next_row_name';
    private string $collectionSettingName = 'collection';
    private string $column1SettingName = 'column_1_name';
    private string $column2SettingName = 'column_2_name';

    protected function setUp(): void
    {
        parent::setUp();

        $this->worksheet = (new Spreadsheet())->getActiveSheet();

        $dataArray = [
            ['skip', 'skip', 'skip', 0],
            ['10', 'Q3', $this->beforeTriggerText, 860],
            ['10', $this->nextRowValue, 'United States', 5850],
            ['skip', 'skip', 'skip', 0],
            ['skip', 'skip', 'skip', 0],
            [$this->collectionTriggerText, 'skip', 'skip', 0],
            [11, 'skip', 13, 0],
            [21, 'skip', 23, 0],
            [null, $this->sameTriggerText, 'United States', $this->sameRowValue],
            [21, 'skip', 23, 0],
        ];

        $this->worksheet->fromArray($dataArray, null, 'B2');

        $this->setting = Setting::factory()->make();
        $this->setting->settings = new Settings(
            [
                $this->sameRowSettingName => ['value' => 5],
                $this->nextRowSettingName => ['value' => 3],
                "$this->collectionSettingName.$this->column1SettingName" => ['value' => 2],
                "$this->collectionSettingName.$this->column2SettingName" => ['value' => 4],
            ],
            DocumentFormats::Spreadsheet
        );
    }

    public function testSameRowElement()
    {
        $element = RowElementFactory::createSameRow($this->sameTriggerText, $this->sameRowSettingName);
        $iterator = new Iterator($this->worksheet, new ScanIteratorMode());

        $found = $iterator->find($element, $this->setting);

        $this->assertCount(1, $found);
        $this->assertEquals($this->sameRowValue, $found[$this->sameRowSettingName]);
    }

    public function testBeforeRowElement()
    {
        $element = RowElementFactory::createBeforeRow($this->beforeTriggerText, $this->nextRowSettingName);
        $iterator = new Iterator($this->worksheet, new ScanIteratorMode());

        $found = $iterator->find($element, $this->setting);

        $this->assertCount(1, $found);
        $this->assertEquals($this->nextRowValue, $found[$this->nextRowSettingName]);
    }

    public function testCollectionElement(): void
    {
        $element = CollectionElementFactory::create(
            $this->collectionSettingName,
            $this->collectionTriggerText,
            $this->column1SettingName,
            $this->column2SettingName
        );

        $iterator = new Iterator($this->worksheet, new ScanIteratorMode());

        $found = $iterator->find($element, $this->setting);

        $this->assertCount(2, $found[$this->collectionSettingName] ?? []);
        $this->assertEquals([11, 13, 21, 23], Arr::flatten($found[$this->collectionSettingName]));
    }
}
