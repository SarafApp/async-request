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

    public function __construct(Connector $connector = new Connector(['verify_peer' => false, 'verify_peer_name' => false]))
    {
        $this->responseHandler = JsonHandler::class;
        $this->browser = (new Browser($connector));
    }

    public function post(string $path, array|string $body = [], array $headers = []): PromiseInterface
    {
        return parent::post($path, Json::create($body), $headers);
    }

    public function streaming(string|MethodsEnum $method, string $path, array|string $body = [], array $headers = []): PromiseInterface
    {
        return parent::streaming($method, $path, Json::create($body), $headers);
    }

    public function put(string $path, array|string $body = [], array $headers = []): PromiseInterface
    {
        return parent::put($path, Json::create($body), $headers);
    }

    public function patch(string $path, array|string $body = [], array $headers = []): PromiseInterface
    {
        return parent::patch($path, Json::create($body), $headers);
    }


}