<?php

namespace Saraf\ResponseHandlers;

use Psr\Http\Message\ResponseInterface;
use React\Http\Message\ResponseException;

interface HandlerInterface
{
    public static function ok(ResponseInterface|array $response);

    public static function error(ResponseException|array $exception);
}