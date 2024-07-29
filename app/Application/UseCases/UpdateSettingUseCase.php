<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTO\SaveSettingRequest;
use App\Domain\Models\Interfaces\SettingRepositoryInterface;
use App\Domain\Models\Setting\Setting;

class UpdateSettingUseCase
{
    public function __construct(private readonly SettingRepositoryInterface $repository)
    {
    }

    public function execute(int $id, SaveSettingRequest $request): Setting
    {
        return $this->repository->update($id, $request);
    }
}
