<?php

namespace Saraf\Methods;

use Saraf\AsyncRequestPropertiesTrait;
use React\Promise\PromiseInterface;

abstract class Methods implements MethodsInterface
{
    use AsyncRequestPropertiesTrait;

    public function get(string $path, array $params = [], array $headers = []): PromiseInterface
    {
        $path = $path . '?' . http_build_query($params);
        return $this->browser->get($path, $headers)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );
    }

    public function delete(string $path, array $params = [], array $headers = []): PromiseInterface
    {
        $path = $path . '?' . http_build_query($params);
        return $this->browser->delete($path, $headers)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );
    }

    public function post(string $path, string $body = "", array $headers = []): PromiseInterface
    {
        return $this->browser->post($path, $headers, $body)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );
    }

    public function streaming(string|MethodsEnum $method, string $path, string $body = "", array $headers = []): PromiseInterface
    {
        return $this->browser->requestStreaming(
            $method,
            $path,
            $headers,
            $body
        )->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );
    }

    public function put(string $path, string $body = "", array $headers = []): PromiseInterface
    {
        return $this->browser->put($path, $headers, $body)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );
    }

    public function patch(string $path, string $body = "", array $headers = []): PromiseInterface
    {
        return $this->browser->patch($path, $headers, $body)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );
    }
}