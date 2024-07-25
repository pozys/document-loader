<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Enums;

enum SchemaComponentTypes: string
{
    case Collection = 'collection';
    case Float = 'float';
    case Integer = 'integer';
    case Row = 'row';
    case String = 'string';
}
