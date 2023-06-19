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