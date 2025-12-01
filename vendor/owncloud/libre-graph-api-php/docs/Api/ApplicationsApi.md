# OpenAPI\Client\ApplicationsApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getApplication()**](ApplicationsApi.md#getApplication) | **GET** /v1.0/applications/{application-id} | Get application by id |
| [**listApplications()**](ApplicationsApi.md#listApplications) | **GET** /v1.0/applications | Get all applications |


## `getApplication()`

```php
getApplication($application_id): \OpenAPI\Client\Model\Application
```

Get application by id

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\ApplicationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$application_id = 'application_id_example'; // string | key: id of application

try {
    $result = $apiInstance->getApplication($application_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ApplicationsApi->getApplication: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **application_id** | **string**| key: id of application | |

### Return type

[**\OpenAPI\Client\Model\Application**](../Model/Application.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listApplications()`

```php
listApplications(): \OpenAPI\Client\Model\CollectionOfApplications
```

Get all applications

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\ApplicationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->listApplications();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ApplicationsApi->listApplications: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\CollectionOfApplications**](../Model/CollectionOfApplications.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
