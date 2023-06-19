<?php

namespace Saraf\Methods;

use Saraf\AsyncRequestPropertiesTrait;
use Saraf\RequestException;
use React\Promise\Promise;
use React\Promise\PromiseInterface;
use function React\Promise\all;

abstract class MethodsMany implements MethodsInterface
{
    use AsyncRequestPropertiesTrait;

    protected array $requests = [];

    /**
     * @throws RequestException
     * @throws \Throwable
     */
    public function executeMany(): PromiseInterface|Promise
    {
        if (count($this->requests) == 0)
            throw new RequestException("There's no request to execute");


        return all($this->requests)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        )->then(function ($results) {
            $this->requests = [];
            return $results;
        });
    }

    public function get(string $path, array $params = [], array $headers = []): static
    {
        $path = $path . '?' . http_build_query($params);
        $this->requests[] = $this->browser->get($path, $headers)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );

        return $this;
    }

    public function delete(string $path, array $params = [], array $headers = []): static
    {
        $path = $path . '?' . http_build_query($params);
        $this->requests[] = $this->browser->delete($path, $headers)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );

        return $this;
    }

    public function post(string $path, string $body = "", array $headers = []): static
    {
        $this->requests[] = $this->browser->post($path, $headers, $body);
        return $this;
    }

    public function streaming(string|MethodsEnum $method, string $path, string $body = "", array $headers = []): static
    {
        $this->requests[] = $this->browser->requestStreaming($method, $path, $headers, $body);
        return $this;
    }

    public function put(string $path, string $body = "", array $headers = []): static
    {
        $this->requests[] = $this->browser->put($path, $headers, $body);
        return $this;
    }

    public function patch(string $path, string $body = "", array $headers = []): static
    {
        $this->requests[] = $this->browser->patch($path, $headers, $body);
        return $this;
    }
}