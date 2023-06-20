<?php

namespace Saraf;

use React\Http\Browser;
use React\Socket\Connector;
use Saraf\ResponseHandlers\BasicHandler;
use Saraf\ResponseHandlers\FileHandler;
use Saraf\ResponseHandlers\HandlerEnum;
use Saraf\ResponseHandlers\JsonHandler;

trait AsyncRequestTrait
{
    use AsyncRequestPropertiesTrait;

    public function __construct(
        Connector $connector = new Connector([
            "tls" => ['verify_peer' => false, 'verify_peer_name' => false]
        ]),
    )
    {
        $this->browser = (new Browser($connector));
    }

    public function setResponseHandler(HandlerEnum $handler): static
    {
        $this->responseHandler = match ($handler) {
            HandlerEnum::Json => JsonHandler::class,
            HandlerEnum::File => FileHandler::class,
            HandlerEnum::Basic => BasicHandler::class,
        };

        return $this;
    }

    public function addHeader(string $key, mixed $value): static
    {
        $this->browser = $this->browser->withHeader($key, $value);
        return $this;
    }

    public function setConfig(array $config): static
    {
        if (isset($config['timeout'])) {
            $this->browser = $this->browser->withTimeout($config['timeout']);
        }

        if (isset($config['baseURL'])) {
            $this->browser = $this->browser->withBase($config['baseURL']);
        }

        if (isset($config['followRedirects'])) {
            $this->browser = $this->browser->withFollowRedirects($config['followRedirects']);
        }

        return $this;
    }
}