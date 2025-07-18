<?php

namespace Saraf;

trait LoggerTrait
{
    public function convertToCurl(string $method, string $path, string $body, array $headers): string
    {
        $curl = "curl -X {$method}";

        foreach ($headers as $key => $value) {
            $curl .= " -H " . escapeshellarg("{$key}: {$value}");
        }

        if (!empty($body)) {
            $curl .= " -d " . escapeshellarg($body);
        }

        $curl .= " " . escapeshellarg($path);

        return $curl;
    }

    public function log(string $method, string $path, string $body, array $headers): void
    {
        $curlCommand = $this->convertToCurl($method, $path, $body, $headers);
        $log = sprintf(
            "[%s] Sending a new request\nCurl Command: %s\n\n",
            date('Y-m-d H:i:s'),
            $curlCommand
        );

        print_r($log);
    }
}