<?php

declare(strict_types=1);

namespace App\Domain\Models\Documents\UTD;

use App\Domain\DTO\ParsedDocumentDto;
use App\Domain\Models\Documents\DocumentSummaryProviderAbstract;
use App\Domain\Models\Documents\ValueObjects\{SummaryLine, UTDSummary};
use Illuminate\Support\{Arr, Collection};

class UTDSummaryProvider extends DocumentSummaryProviderAbstract
{
    public function summarizeDocument(ParsedDocumentDto $document): UTDSummary
    {
        return new UTDSummary([
            'header' => $this->summarizeHeader($document->content),
            ...$this->getGoodsSummary($document->content),
        ]);
    }

    private function summarizeHeader(array $content): array
    {
        return [
            new SummaryLine('number', data_get($content, 'number')),
            new SummaryLine('date', data_get($content, 'date')),
            new SummaryLine('goods_count', $this->getGoods($content)->count()),
        ];
    }

    private function getGoodsSummary(array $content): array
    {
        $asIs = $this->getGoodsAsIs($content);
        $asToBe = $this->getGoodsAsToBe($content);
        $diff = $this->summarizeDiff($asIs, $asToBe);

        return ['asIs' => $asIs, 'asToBe' => $asToBe, 'diff' => $diff];
    }

    private function getGoodsAsIs(array $content): array
    {
        return [
            new SummaryLine('amount_as_is', data_get($content, 'amount')),
            new SummaryLine('vat_as_is', data_get($content, 'vat')),
            new SummaryLine('amount_with_vat_as_is', data_get($content, 'amount_with_vat'))
        ];
    }

    private function getGoodsAsToBe(array $content): array
    {
        $goods = $this->getGoods($content);

        $amount = $this->calculateColumnSum($goods, 'amount');
        $VAT = $this->calculateColumnSum($goods, 'vat');
        $amountWithVAT = $this->calculateColumnSum($goods, 'amount_with_vat');

        return [
            new SummaryLine('amount_as_to_be', $amount),
            new SummaryLine('vat_as_to_be', $VAT),
            new SummaryLine('amount_with_vat_as_to_be', $amountWithVAT),
        ];
    }

    private function getGoods(array $content): Collection
    {
        $groupedContent = Arr::undot($content);
        $goods = data_get($groupedContent, 'goods');

        if ($goods === null) {
            // TODO: throw exception
            throw new \InvalidArgumentException('Goods not found in document content');
        }

        return collect($goods);
    }

    private function calculateColumnSum(Collection $data, string $column): int|float
    {
        return $data->pluck($column)->sum();
    }

    private function summarizeDiff(array $asIs, array $asToBe): array
    {
        $goodsDiff = $this->calculateGoodsDiff($asIs, $asToBe);

        return Arr::map($goodsDiff, fn (int|float $diff, string $parameter) => new SummaryLine($parameter, $diff));
    }

    private function calculateGoodsDiff(array $asIs, array $asToBe): array
    {
        $parametersMap = [
            'amount_diff' => ['amount_as_is', 'amount_as_to_be'],
            'vat_diff' => ['vat_as_is', 'vat_as_to_be'],
            'amount_with_vat_diff' => ['amount_with_vat_as_is', 'amount_with_vat_as_to_be'],
        ];

        return Arr::map($parametersMap, function (array $comparedParameters) use ($asIs, $asToBe) {
            [$asIsParameter, $asToBeParameter] = $comparedParameters;

            $asIsValue = $this->findReportLine($asIsParameter, ...$asIs)?->value;
            $asToBeValue = $this->findReportLine($asToBeParameter, ...$asToBe)?->value;

            if ($asIsValue === null) {
                // TODO: throw exception
                throw new \InvalidArgumentException("Report line with parameter '$asIsParameter' not found");
            }

            if ($asToBeValue === null) {
                // TODO: throw exception
                throw new \InvalidArgumentException("Report line with parameter '$asToBeParameter' not found");
            }

            return $asIsValue - $asToBeValue;
        });
    }

    private function findReportLine(string $parameter, SummaryLine ...$report): ?SummaryLine
    {
        return Arr::first($report, fn (SummaryLine $reportLine) => $reportLine->parameter === $parameter);
    }
}
