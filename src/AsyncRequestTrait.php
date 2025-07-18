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

    private string $path = "";
    private string $baseURL = "";
    private array $trackedHeaders = [];

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
        $this->trackedHeaders[$key] = $value;
        return $this;
    }

    public function addHeaders(array $headers): void
    {
        foreach ($headers as $key => $value) {
            $this->browser = $this->browser->withHeader($key, $value);
            $this->trackedHeaders[$key] = $value;
        }
    }

    /**
     * @throws \Exception
     */
    public function setConfig(array $config): static
    {
        if (isset($config['timeout'])) {
            $this->browser = $this->browser->withTimeout($config['timeout']);
        }

        if (isset($config['baseURL'])) {
            $this->setBaseURL($config['baseURL']);
        }

        if (isset($config['followRedirects'])) {
            $this->browser = $this->browser->withFollowRedirects($config['followRedirects']);
        }

        if (isset($config['maxBufferSize'])) {
            $this->browser = $this->browser->withResponseBuffer($config['maxBufferSize']);
        }

        return $this;
    }


    /**
     * This method ignores the query params in baseURL
     * @param string $baseURL
     * @throws \Exception
     */
    private function setBaseURL(string $baseURL): void
    {
        $url = parse_url($baseURL);
        if (!isset($url['scheme'], $url['host'])) {
            throw new \Exception("URL PARSER ERROR");
        }

        if (isset($url['path'])) {
            $this->path = $url['path'];
        }

        $finalBaseURL = $url['scheme'] . "://" . $url['host'];
        if (isset($url['port']))
            $finalBaseURL .= ":" . $url['port'];

        $this->baseURL = $finalBaseURL;
        $this->browser = $this->browser->withBase($finalBaseURL);
    }

    /**
     * Generate a curl command for the given request parameters
     * 
     * @param string $method HTTP method (GET, POST, PUT, etc.)
     * @param string $path Request path (will be appended to baseURL)
     * @param array $headers Additional headers for this request
     * @param string $body Request body (for POST, PUT, PATCH)
     * @param array $params Query parameters (for GET, DELETE)
     * @return string The curl command
     */
    public function generateCurlCommand(string $method, string $path, array $headers = [], string $body = "", array $params = []): string
    {
        // Build the full URL
        $fullPath = $this->path . $path;
        
        // Add query parameters for GET/DELETE requests
        if (!empty($params) && in_array(strtoupper($method), ['GET', 'DELETE'])) {
            $fullPath .= '?' . http_build_query($params);
        }
        
        $fullUrl = $this->baseURL . $fullPath;
        
        // Start building curl command
        $curl = "curl";
        
        // Add method if not GET
        if (strtoupper($method) !== 'GET') {
            $curl .= " -X " . strtoupper($method);
        }
        
        // Merge tracked headers with request-specific headers
        $allHeaders = array_merge($this->trackedHeaders, $headers);
        
        // Add headers
        foreach ($allHeaders as $key => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            $curl .= " -H " . escapeshellarg($key . ": " . $value);
        }
        
        // Add body if present
        if (!empty($body)) {
            $curl .= " -d " . escapeshellarg($body);
        }
        
        // Add URL (always last)
        $curl .= " " . escapeshellarg($fullUrl);
        
        return $curl;
    }
}