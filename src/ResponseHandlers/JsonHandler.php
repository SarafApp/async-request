<?php

namespace Saraf\ResponseHandlers;

use Psr\Http\Message\ResponseInterface;
use React\Http\Message\ResponseException;
use Saraf\RequestException;

class JsonHandler implements HandlerInterface
{
    /**
     * @throws RequestException
     */
    public static function ok(ResponseInterface|array $response): array
    {
        if (is_array($response)) {
            $results = [];
            foreach ($response as $r) {
                $results[] = [
                    "result" => true,
                    'code' => $r->getStatusCode(),
                    'body' => json_decode($r->getBody()->getContents(), true),
                    'headers' => $r->getHeaders()
                ];
            }

            return $results;
        }

        if ($response instanceof ResponseInterface) {
            return [
                "result" => true,
                'code' => $response->getStatusCode(),
                'body' => json_decode($response->getBody()->getContents(), true),
                'headers' => $response->getHeaders()
            ];
        }

        throw new RequestException("Can't identify response type");
    }

    /**
     * @throws RequestException
     */
    public static function error(\Exception|array $exception): array
    {
        if (is_array($exception)) {
            $results = [];
            foreach ($exception as $e) {
                if ($exception instanceof ResponseException) {
                    $response = $e->getResponse();
                    $results[] = [
                        'result' => true,
                        'code' => $response->getStatusCode(),
                        'body' => json_decode($response->getBody()->getContents(), true),
                        'headers' => $response->getHeaders()
                    ];
                } else {
                    $results[] = [
                        'result' => false,
                        'error' => $exception->getMessage(),
                        'exception' => $exception,
                        'code' => $exception->getCode(),
                        'body' => null,
                        'headers' => null,
                    ];
                }
            }
            return $results;
        }

        if ($exception instanceof ResponseException) {
            $response = $exception->getResponse();
            return [
                'result' => true,
                'code' => $response->getStatusCode(),
                'body' => json_decode($response->getBody()->getContents(), true),
                'headers' => $response->getHeaders()
            ];
        }

        if ($exception instanceof \Exception) {
            return [
                'result' => false,
                'error' => $exception->getMessage(),
                'exception' => $exception,
                'code' => $exception->getCode(),
                'body' => null,
                'headers' => null,
            ];
        }

        throw new RequestException("Can't identify response type");
    }
}