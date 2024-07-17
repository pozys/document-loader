<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\Models\Documents\Document;

interface DocumentProcessorInterface
{
    public function read(string $path, array $schema): Document;
}
