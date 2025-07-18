<?php

require "vendor/autoload.php";

// Example with AsyncRequest
$api = new \Saraf\AsyncRequest();

$api->setConfig([
    "baseURL" => "https://jsonplaceholder.typicode.com",
    "timeout" => 30,
]);

$api->addHeader("Authorization", "Bearer your-token-here");
$api->addHeader("User-Agent", "AsyncRequest/1.0");

// Generate curl commands for different request types

// GET request with query parameters
$getCurl = $api->getCurl('GET', '/posts', [], '', ['userId' => 1]);
echo "GET Request:\n";
echo $getCurl . "\n\n";

// POST request with JSON body
$postCurl = $api->getCurl('POST', '/posts', ['Content-Type' => 'application/json'], '{"title":"foo","body":"bar","userId":1}');
echo "POST Request:\n";
echo $postCurl . "\n\n";

// PUT request
$putCurl = $api->getCurl('PUT', '/posts/1', ['Content-Type' => 'application/json'], '{"id":1,"title":"updated","body":"updated","userId":1}');
echo "PUT Request:\n";
echo $putCurl . "\n\n";

// DELETE request
$deleteCurl = $api->getCurl('DELETE', '/posts/1');
echo "DELETE Request:\n";
echo $deleteCurl . "\n\n";

// Example with AsyncRequestJson
$jsonApi = new \Saraf\AsyncRequestJson();

$jsonApi->setConfig([
    "baseURL" => "https://api.example.com",
]);

$jsonApi->addHeader("Authorization", "Bearer your-token");

// Generate curl for JSON API request
$jsonCurl = $jsonApi->getCurl('POST', '/users', [], '{"name":"John","email":"john@example.com"}');
echo "JSON API Request:\n";
echo $jsonCurl . "\n\n"; 