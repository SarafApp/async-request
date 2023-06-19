<?php

namespace Saraf\RequestBody;

class UrlEncodedFormData
{
    public static function create(array $body): string
    {
        return http_build_query($body);
    }
}