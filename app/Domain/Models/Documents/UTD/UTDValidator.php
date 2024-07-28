<?php

declare(strict_types=1);

namespace App\Domain\Models\Documents\UTD;

use App\Domain\Models\Documents\DocumentValidatorAbstract;
use App\Domain\Models\Documents\ValueObjects\{DocumentSummaryAbstract, ValidationError};

class UTDValidator extends DocumentValidatorAbstract
{
    public function validate(DocumentSummaryAbstract $summary): array
    {
        if (count($summary->diff) === 0) {
            return [];
        }

        return [new ValidationError('goods_errors', 'goods_errors_message')];
    }
}
