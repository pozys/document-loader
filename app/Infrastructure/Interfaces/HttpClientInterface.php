<?php

declare(strict_types=1);

namespace App\Infrastructure\Interfaces;

use Illuminate\Http\Client\Response;

interface HttpClientInterface
{
    public function addHeader(string $name, string $value): self;

    public function setUrl(string $url): self;

    public function setBody(array $body): self;

    public function get(): Response;

    public function head(): Response;

    public function post(): Response;

    public function patch(): Response;

    public function put(): Response;

    public function failed(): bool;

    public function getResponseBody(): ?string;
}
