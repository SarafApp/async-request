<?php

namespace Saraf;

use React\Http\Browser;
use React\Promise\PromiseInterface;
use React\Socket\Connector;
use Saraf\Methods\Methods;
use Saraf\Methods\MethodsEnum;
use Saraf\RequestBody\Json;
use Saraf\ResponseHandlers\JsonHandler;

class AsyncRequestJson extends Methods
{
    use AsyncRequestTrait;

    public function __construct(Connector $connector = new Connector([
        "tls" => ['verify_peer' => false, 'verify_peer_name' => false]
    ]))
    {
        $this->responseHandler = JsonHandler::class;
        $this->browser = (new Browser($connector))->withHeader('Content-Type', 'application/json');
    }

    public function get(string $path, array $params = [], array $headers = []): PromiseInterface
    {
        return parent::get($this->path . $path, $params, $headers);
    }

    public function delete(string $path, array $params = [], array $headers = []): PromiseInterface
    {
        return parent::delete($this->path . $path, $params, $headers);
    }

    public function post(string $path, array|string $body = [], array $headers = []): PromiseInterface
    {
        return parent::post($this->path . $path, Json::create($body), $headers);
    }

    public function streaming(string|MethodsEnum $method, string $path, array|string $body = [], array $headers = []): PromiseInterface
    {
        return parent::streaming($method, $this->path . $path, Json::create($body), $headers);
    }

    public function put(string $path, array|string $body = [], array $headers = []): PromiseInterface
    {
        return parent::put($this->path . $path, Json::create($body), $headers);
    }

    public function patch(string $path, array|string $body = [], array $headers = []): PromiseInterface
    {
        return parent::patch($this->path . $path, Json::create($body), $headers);
    }
}