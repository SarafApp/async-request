<?php

namespace Saraf\ResponseHandlers;

use BadMethodCallException;
use Psr\Http\Message\ResponseInterface;
use React\Http\Message\ResponseException;

class FileHandler implements HandlerInterface
{

    public static function ok(array|ResponseInterface $response)
    {
        throw new BadMethodCallException("Not Implemented");
    }

    public static function error(ResponseException|array $exception)
    {
        throw new BadMethodCallException("Not Implemented");
    }
}