<?php

namespace Saraf\Methods;

use React\Promise\PromiseInterface;

interface MethodsInterface
{
    public function get(string $path, array $params = [], array $headers = []): static|PromiseInterface;

    public function delete(string $path, array $params = [], array $headers = []): static|PromiseInterface;

    public function post(string $path, string $body = "", array $headers = []): static|PromiseInterface;

    public function streaming(string|MethodsEnum $method, string $path, string $body = "", array $headers = []): static|PromiseInterface;

    public function put(string $path, string $body = "", array $headers = []): static|PromiseInterface;

    public function patch(string $path, string $body = "", array $headers = []): static|PromiseInterface;

}