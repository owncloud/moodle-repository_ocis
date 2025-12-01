# OpenAPI\Client\ActivitiesApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getActivities()**](ActivitiesApi.md#getActivities) | **GET** /v1beta1/extensions/org.libregraph/activities | Get activities |


## `getActivities()`

```php
getActivities($kql): \OpenAPI\Client\Model\CollectionOfActivities
```

Get activities

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\ActivitiesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$kql = resourceid:a0ca6a90-a365-4782-871e-d44447bbc668$a0ca6a90-a365-4782-871e-d44447bbc668 depth:2; // string

try {
    $result = $apiInstance->getActivities($kql);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ActivitiesApi->getActivities: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **kql** | **string**|  | [optional] |

### Return type

[**\OpenAPI\Client\Model\CollectionOfActivities**](../Model/CollectionOfActivities.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
