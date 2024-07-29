<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\Interfaces\DocumentLoaderInterface;
use App\Domain\Models\Interfaces\DocumentRepositoryInterface;

class SendDocumentUseCase
{
    public function __construct(
        private readonly DocumentRepositoryInterface $repository,
        private readonly DocumentLoaderInterface $loader
    ) {
    }

    public function execute(int $id): void
    {
        $document = $this->repository->get($id);
        $this->loader->sendDocument($document);
    }
}
