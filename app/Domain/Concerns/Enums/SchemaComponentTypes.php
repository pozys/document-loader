<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Enums;

enum SchemaComponentTypes: string
{
    case Array = 'array';
    case Float = 'float';
    case Integer = 'integer';
    case Object = 'object';
    case String = 'string';
}
