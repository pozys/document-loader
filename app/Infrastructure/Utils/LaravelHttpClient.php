<?php

declare(strict_types=1);

namespace App\Infrastructure\Utils;

use App\Infrastructure\Interfaces\HttpClientInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class LaravelHttpClient implements HttpClientInterface
{
    private string $url = '';
    private array $headers = [];
    private Response $response;

    public function __construct(private readonly Http $http)
    {
    }

    public function addHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setBody(array $body): self
    {
        $this->http::withBody(json_encode($body));

        return $this;
    }

    public function get(): Response
    {
        return $this->send('GET');
    }

    public function head(): Response
    {
        return $this->send('HEAD');
    }

    public function post(): Response
    {
        return $this->send('POST');
    }

    public function patch(): Response
    {
        return $this->send('PATCH');
    }

    public function put(): Response
    {
        return $this->send('PUT');
    }

    public function send(string $method): Response
    {
        if ($this->headers) {
            $this->http::withHeaders($this->headers);
        }

        $this->response = $this->http::send($method, $this->url);

        return $this->response;
    }

    public function failed(): bool
    {
        return !$this->response->successful();
    }

    public function getResponseBody(): ?string
    {
        return $this->response->body();
    }
}
