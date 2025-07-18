<?php

namespace Saraf;

trait CurlDumpTrait
{
    /**
     * Generate a curl command for the given request parameters
     * 
     * @param string $method HTTP method (GET, POST, PUT, etc.)
     * @param string $path Request path (will be appended to baseURL)
     * @param array $headers Additional headers for this request
     * @param array $body Request body (for POST, PUT, PATCH)
     * @param array $queryParams Query parameters (for GET, DELETE)
     * @return string The curl command
     */
    public function getCurl(string $method, string $path, array $headers = [], array $body = [], array $queryParams = []): string
    {
        // Build the full URL
        $fullPath = $this->path . $path;
        
        // Add query parameters for GET/DELETE requests
        if (!empty($queryParams) && in_array(strtoupper($method), ['GET', 'DELETE'])) {
            $fullPath .= '?' . http_build_query($queryParams);
        }
        
        $baseUrl = $this->extractBaseUrlFromBrowser();
        $fullUrl = $baseUrl . $fullPath;
        
        // Start building curl command
        $curl = "curl";
        
        // Add method if not GET
        if (strtoupper($method) !== 'GET') {
            $curl .= " -X " . strtoupper($method);
        }
        
        // Extract headers from browser and merge with request-specific headers
        $browserHeaders = $this->extractHeadersFromBrowser();
        $allHeaders = array_merge($browserHeaders, $headers);
        
        // Add headers
        foreach ($allHeaders as $key => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            $curl .= " -H " . escapeshellarg($key . ": " . $value);
        }
        
        // Add body if present
        if (!empty($body)) {
            $bodyString = is_array($body) ? json_encode($body) : $body;
            $curl .= " -d " . escapeshellarg($bodyString);
        }
        
        // Add URL (always last)
        $curl .= " " . escapeshellarg($fullUrl);
        
        return $curl;
    }

    /**
     * Extract base URL from the browser object using reflection
     */
    private function extractBaseUrlFromBrowser(): string
    {
        try {
            $reflection = new \ReflectionClass($this->browser);
            $baseProperty = $reflection->getProperty('baseUrl');
            $baseProperty->setAccessible(true);
            return $baseProperty->getValue($this->browser) ?: '';
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Extract headers from the browser object using reflection
     */
    private function extractHeadersFromBrowser(): array
    {
        try {
            $reflection = new \ReflectionClass($this->browser);
            $headersProperty = $reflection->getProperty('headers');
            $headersProperty->setAccessible(true);
            return $headersProperty->getValue($this->browser) ?: [];
        } catch (\Exception $e) {
            return [];
        }
    }
} 