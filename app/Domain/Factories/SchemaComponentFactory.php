<?php

declare(strict_types=1);

namespace App\Domain\Factories;

use App\Domain\Concerns\Enums\SchemaComponentTypes;
use App\Domain\Concerns\Models\SchemaComponents\AbstractSchemaComponent;
use App\Domain\Concerns\Models\SchemaComponents\Collection;
use App\Domain\Concerns\Models\SchemaComponents\Primitive;
use App\Domain\Concerns\Models\SchemaComponents\Row;

class SchemaComponentFactory
{
    public static function make(array $data): AbstractSchemaComponent
    {
        self::validate($data);

        $type = SchemaComponentTypes::from($data['type']);

        return match ($type) {
            SchemaComponentTypes::Collection => new Collection($type, $data),
            SchemaComponentTypes::Row => new Row($type, $data),
            default => new Primitive($type, $data),
        };
    }

    private static function validate(array $data): void
    {
        $type = data_get($data, 'type');
        if (!$type) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No type provided for schema component');
        }

        if (SchemaComponentTypes::tryFrom($type) === null) {
            // TODO: throw exception
            throw new \InvalidArgumentException("Invalid type - '$type' - provided for schema component");
        }
    }
}
