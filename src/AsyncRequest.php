<?php

namespace Saraf;

use React\Promise\PromiseInterface;
use Saraf\Methods\Methods;
use Saraf\Methods\MethodsEnum;

class AsyncRequest extends Methods
{
    use AsyncRequestTrait;

    public function get(string $path, array $params = [], array $headers = []): PromiseInterface
    {
        return parent::get($this->path.$path, $params, $headers);
    }

    public function delete(string $path, array $params = [], array $headers = []): PromiseInterface
    {
        return parent::delete($this->path.$path, $params, $headers);
    }

    public function post(string $path, string $body = "", array $headers = []): PromiseInterface
    {
        return parent::post($this->path.$path, $body, $headers);
    }

    public function streaming(string|MethodsEnum $method, string $path, string $body = "", array $headers = []): PromiseInterface
    {
        return parent::streaming($method, $this->path.$path, $body, $headers);
    }

    public function put(string $path, string $body = "", array $headers = []): PromiseInterface
    {
        return parent::put($this->path.$path, $body, $headers);
    }

    public function patch(string $path, string $body = "", array $headers = []): PromiseInterface
    {
        return parent::patch($this->path.$path, $body, $headers);
    }


}