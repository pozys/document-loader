<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

interface SettingValueInterface
{
    public function __construct(array $data);
}
