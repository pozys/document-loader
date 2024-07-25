<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils;

use Symfony\Component\Yaml\Yaml;

class YamlParser
{
    public function __construct(private Yaml $parser)
    {
    }

    public function parseFile(string $path): array
    {
        $parsedFile = $this->parser->parseFile($path);

        if (!is_array($parsedFile)) {
            // TODO: throw exception
            throw new \Exception('Invalid YAML file');
        }

        return $parsedFile;
    }
}
