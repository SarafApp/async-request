<?php

require "vendor/autoload.php";

$api = new \Saraf\AsyncRequestJson();

$api->setConfig([
    "baseURL" => "https://example.com/api",
    "followRedirects" => true,
    "timeout" => .9,
    "headers" => [
        "Content-Type" => 'application/json'
    ]
]);

$api->get("/users")->then(function ($response) {
    echo json_encode($response);
});