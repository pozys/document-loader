<?php

namespace Tests\Unit;

use App\Infrastructure\Utils\YamlParser;
use PHPUnit\Framework\TestCase;

class YamlParserTest extends TestCase
{
    public function getFixtureFullPath($fixtureName)
    {
        $parts = [__DIR__, '/../fixtures', $fixtureName];

        return realpath(implode('/', $parts));
    }

    public function testParseFileReturnsArrayWhenFileIsValid(): void
    {
        $yamlParser = app(YamlParser::class);

        $filePath = $this->getFixtureFullPath('schema.yaml');
        $result = $yamlParser->parseFile($filePath);

        $this->assertIsArray($result);
    }
}
