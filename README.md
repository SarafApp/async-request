# Saraf Async Request (A ReactPHP Wrapper)

It's just a simple wrapper/helper around `reactphp/http` library. which creates a better **Developer Experience** and
faster development..

## Easy Setup

```php
// initialize basic class
$api = new \Saraf\AsyncRequestJson()
$api->setConfig([
    "baseURL" => "https://jsonplaceholder.typicode.com"
]);

// It will return Promise
$api->post("/todos", [
    'title' => 'learn async-request lib',
    'isDone' => false
])->then(function ($response) {
    // $response contains result, status code, headers and body of that request      
});
```

### Customize Response Handler

This way response body automatically decoded

```php
$api->setResponseHandler(\Saraf\ResponseHandlers\HandlerEnum::Json);
```

### Generate Curl Commands

You can generate curl commands for any request to debug or share with others:

```php
$api = new \Saraf\AsyncRequestJson();
$api->setConfig([
    "baseURL" => "https://jsonplaceholder.typicode.com"
]);

$api->addHeader("Authorization", "Bearer your-token");

// Generate curl command for a POST request
$curlCommand = $api->getCurl('POST', '/posts', [], '{"title":"foo","body":"bar","userId":1}');
echo $curlCommand;
// Output: curl -X POST -H 'Authorization: Bearer your-token' -d '{"title":"foo","body":"bar","userId":1}' 'https://jsonplaceholder.typicode.com/posts'

// Generate curl command for a GET request with query parameters
$curlCommand = $api->getCurl('GET', '/posts', [], '', ['userId' => 1]);
echo $curlCommand;
// Output: curl -H 'Authorization: Bearer your-token' 'https://jsonplaceholder.typicode.com/posts?userId=1'
```