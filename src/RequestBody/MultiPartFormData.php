<?php

namespace Saraf\RequestBody;

class MultiPartFormData
{
    protected const CLIENT_NAME = "AsyncRequest";

    /*
     * [
     *   "address" => [ "contentType" => "text/plain", "value" => "some value" ],
     *   "profilePicture" => [ "contentType"=> "image/png", "value" => "bytes of the image in here" ],
     * ]
     */
    public static function create(array $body): array
    {
        $finalBody = "";
        $boundary = time();
        $formDataKey = "Content-Disposition: form-data; name=";


        foreach ($body as $key => $data) {
            $finalBody .= '------' . self::CLIENT_NAME . $boundary . "\n";
            $finalBody .= $formDataKey . "\"" . $key . "\"" . "\n";
            if (isset($data['contentType']))
                $finalBody .= "Content-Type: " . $data['contentType'] . "\n\n";
            else
                $finalBody .= "\n";
            $finalBody .= $data['value'] . "\n";
            $finalBody .= '------' . self::CLIENT_NAME . $boundary . "\n";
        }

        return [
            'body' => $finalBody,
            'boundary' => '------' . self::CLIENT_NAME . $boundary
        ];
    }
}