<?php

namespace Saraf\Methods;

use React\Promise\PromiseInterface;
use Saraf\AsyncRequestPropertiesTrait;
use Saraf\LoggerTrait;

abstract class Methods implements MethodsInterface
{
    use AsyncRequestPropertiesTrait;
    use LoggerTrait;

    public function get(string $path, array $params = [], array $headers = []): PromiseInterface
    {
        $path = $path . '?' . http_build_query($params);
        if ($this->isLoggerActive) {
            $this->log('GET', $path, '', $headers);
        }
        return $this->browser->get($path, $headers)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );
    }

    public function delete(string $path, array $params = [], array $headers = []): PromiseInterface
    {
        $path = $path . '?' . http_build_query($params);
        if ($this->isLoggerActive) {
            $this->log('DELETE', $path, '', $headers);
        }
        return $this->browser->delete($path, $headers)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );
    }

    public function post(string $path, string $body = "", array $headers = []): PromiseInterface
    {
        if ($this->isLoggerActive) {
            $this->log('POST', $path, $body, $headers);
        }
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
        if ($this->isLoggerActive) {
            $this->log('PUT', $path, $body, $headers);
        }
        return $this->browser->put($path, $headers, $body)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );
    }

    public function patch(string $path, string $body = "", array $headers = []): PromiseInterface
    {
        if ($this->isLoggerActive) {
            $this->log('PATCH', $path, $body, $headers);
        }
        return $this->browser->patch($path, $headers, $body)->then(
            [$this->responseHandler, 'ok'],
            [$this->responseHandler, 'error']
        );
    }
}