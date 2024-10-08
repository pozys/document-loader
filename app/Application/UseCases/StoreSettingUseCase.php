<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTO\SaveSettingRequest;
use App\Domain\Models\Interfaces\SettingRepositoryInterface;
use App\Domain\Models\Setting\Setting;

class StoreSettingUseCase
{
    public function __construct(private readonly SettingRepositoryInterface $repository)
    {
    }

    public function execute(SaveSettingRequest $request): Setting
    {
        return $this->repository->store($request);
    }
}
