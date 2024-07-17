<?php

declare(strict_types=1);

namespace App\Domain\Factories;

use App\Domain\Concerns\Enums\SchemaComponentTypes;
use App\Domain\Concerns\Models\SchemaComponents\AbstractSchemaComponent;
use App\Domain\Concerns\Models\SchemaComponents\Collection;
use App\Domain\Concerns\Models\SchemaComponents\Primitive;
use App\Domain\Concerns\Models\SchemaComponents\Structure;

class SchemaComponentFactory
{
    public static function make(string $name, array $data): AbstractSchemaComponent
    {
        self::validate($data);

        $type = SchemaComponentTypes::from($data['type']);

        return match ($type) {
            SchemaComponentTypes::Array => new Collection($type, $name, $data),
            SchemaComponentTypes::Object => new Structure($type, $name, $data),
            default => new Primitive($type, $name),
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
            throw new \InvalidArgumentException('Invalid type provided for schema component');
        }
    }
}
