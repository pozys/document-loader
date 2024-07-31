<?php

namespace Tests\Feature;

use App\Domain\Concerns\Enums\SchemaComponentTypes;
use Tests\TestCase;
use App\Domain\Concerns\Services\DocumentSchemaConverter;
use App\Domain\Concerns\Models\DocumentSchema;
use App\Domain\Enums\DocumentTypes;
use App\Domain\Factories\SchemaComponentFactory;

class DocumentSchemaConverterTest extends TestCase
{
    public function testValidDocumentType()
    {
        $data = [
            'meta' => ['type' => DocumentTypes::UTD->value],
            'schema' => [
                [
                    'type' => SchemaComponentTypes::Row->value,
                    'trigger' => ['text' => 'text', 'position' => 'same'],
                    'properties' => [
                        [
                            'name' => 'property1',
                            'type' => SchemaComponentTypes::String->value,
                        ],
                        [
                            'name' => 'property2',
                            'type' => SchemaComponentTypes::Integer->value,
                        ]
                    ]
                ],
                [
                    'type' => SchemaComponentTypes::Row->value,
                    'trigger' => ['text' => 'text', 'position' => 'before'],
                    'properties' => [
                        [
                            'name' => 'property1',
                            'type' => SchemaComponentTypes::String->value,
                        ],
                        [
                            'name' => 'property2',
                            'type' => SchemaComponentTypes::Integer->value,
                        ]
                    ]
                ],
                [
                    'type' => SchemaComponentTypes::Collection->value,
                    'trigger' => ['text' => 'text', 'position' => 'before'],
                    'name' => 'goods',
                    'properties' => [
                        [
                            'name' => 'property1',
                            'type' => SchemaComponentTypes::String->value,
                            'is_control' => true,
                        ],
                        [
                            'name' => 'property2',
                            'type' => SchemaComponentTypes::Integer->value,
                        ]
                    ]
                ]
            ]
        ];

        $converter = new DocumentSchemaConverter(app(SchemaComponentFactory::class));

        $result = $converter->toDocumentSchema($data);

        $this->assertInstanceOf(DocumentSchema::class, $result);
        $this->assertEquals(DocumentTypes::UTD, $result->getDocumentType());
        $this->assertCount(3, $result->getElements());
    }

    public function testInvalidDocumentType()
    {
        $mockSchemaComponentFactory = $this->createMock(SchemaComponentFactory::class);

        $data = [
            'meta' => ['type' => 'InvalidType'],
            'schema' => ['key1' => 'value1', 'key2' => 'value2']
        ];

        $converter = new DocumentSchemaConverter($mockSchemaComponentFactory);

        $this->expectException(\InvalidArgumentException::class);

        $converter->toDocumentSchema($data);
    }
}
