<?php

namespace Tests\Feature\DocumentSummaryProvider;

use App\Domain\DTO\ParsedDocumentDto;
use App\Domain\Models\Documents\UTD\UTDSummaryProvider;
use App\Domain\Models\Documents\ValueObjects\{SummaryLine, UTDSummary};
use Tests\TestCase;

class UTDSummaryProviderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCorrectDocument(): void
    {
        $provider = app(UTDSummaryProvider::class);
        $summary = $provider->summarizeDocument($this->createCorrectDocumentDto());
        $this->assertEquals($this->createReportWithoutErrors(), $summary);
    }

    public function testDocumentWithWrongAmount(): void
    {
        $provider = app(UTDSummaryProvider::class);
        $summary = $provider->summarizeDocument($this->createWrongDocumentDto());
        $this->assertEquals($this->createReportWithErrors(), $summary);
    }

    private function createCorrectDocumentDto(): ParsedDocumentDto
    {
        return new ParsedDocumentDto($this->provideBaseDocumentDtoContent());
    }

    private function createWrongDocumentDto(): ParsedDocumentDto
    {
        $content = $this->provideBaseDocumentDtoContent();
        $content['amount'] += 0.02;

        return new ParsedDocumentDto($content);
    }

    private function provideBaseDocumentDtoContent(): array
    {
        return [
            'number' => '123',
            'date' => '2020-01-01',
            'amount' => 8351.97,
            'vat' => 1670.39,
            'amount_with_vat' => 10022.36,
            'goods' => [
                ['amount' => 835.75, 'vat' => 167.15, 'amount_with_vat' => 1002.9],
                ['amount' => 7217.56, 'vat' => 1443.51, 'amount_with_vat' => 8661.07],
                ['amount' => 298.66, 'vat' => 59.73, 'amount_with_vat' => 358.39],
            ],
        ];
    }

    private function createReportWithoutErrors(): UTDSummary
    {
        return new UTDSummary([
            'header' => [
                new SummaryLine('number', '123'),
                new SummaryLine('date', '2020-01-01'),
                new SummaryLine('goods_count', 3),
            ],
            'asIs' => [
                new SummaryLine('amount_as_is', 8351.97),
                new SummaryLine('vat_as_is', 1670.39),
                new SummaryLine('amount_with_vat_as_is', 10022.36)
            ],
            'asToBe' => [
                new SummaryLine('amount_as_to_be', 8351.97),
                new SummaryLine('vat_as_to_be', 1670.39),
                new SummaryLine('amount_with_vat_as_to_be', 10022.36)
            ],
            'diff' => [
                new SummaryLine('amount_diff', 0),
                new SummaryLine('vat_diff', 0),
                new SummaryLine('amount_with_vat_diff', 0),
            ],
        ]);
    }

    private function createReportWithErrors(): UTDSummary
    {
        return new UTDSummary([
            'header' => [
                new SummaryLine('number', '123'),
                new SummaryLine('date', '2020-01-01'),
                new SummaryLine('goods_count', 3),
            ],
            'asIs' => [
                new SummaryLine('amount_as_is', 8351.99),
                new SummaryLine('vat_as_is', 1670.39),
                new SummaryLine('amount_with_vat_as_is', 10022.36)
            ],
            'asToBe' => [
                new SummaryLine('amount_as_to_be', 8351.97),
                new SummaryLine('vat_as_to_be', 1670.39),
                new SummaryLine('amount_with_vat_as_to_be', 10022.36)
            ],
            'diff' => [
                new SummaryLine('amount_diff', 0.02),
                new SummaryLine('vat_diff', 0),
                new SummaryLine('amount_with_vat_diff', 0),
            ],
        ]);
    }
}

// $content = [
//     'number' => '123',
//     'date' => '2020-01-01',
//     'goods_count' => 3,
//     'amount_as_is' => 8351.97,
//     'vat_as_is' => 1670.39,
//     'amount_with_vat_as_is' => 10022.36,
//     'amount_as_to_be' => 8351.97,
//     'vat_as_to_be' => 1670.39,
//     'amount_with_vat_as_to_be' => 10022.36,
//     'goods' => [
//         ['amount' => 835.75, 'vat' => 167.15, 'amount_with_vat' => 1002.9],
//         ['amount' => 7217.56, 'vat' => 1443.51, 'amount_with_vat' => 8661.07],
//         ['amount' => 298.66, 'vat' => 59.73, 'amount_with_vat' => 358.39],
//     ],
//     'amount_diff' => 0,
//     'vat_diff' => 0,
//     'amount_with_vat_diff' => 0,
// ];
