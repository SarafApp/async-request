<?php

namespace Saraf\RequestBody;

class Json
{
    public static function create(array $body): string
    {
        return json_encode($body);
    }
}