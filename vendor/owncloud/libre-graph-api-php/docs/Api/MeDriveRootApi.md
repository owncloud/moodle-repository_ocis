# OpenAPI\Client\MeDriveRootApi

All URIs are relative to https://ocis.ocis-traefik.latest.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**homeGetRoot()**](MeDriveRootApi.md#homeGetRoot) | **GET** /v1.0/me/drive/root | Get root from personal space |


## `homeGetRoot()`

```php
homeGetRoot(): \OpenAPI\Client\Model\DriveItem
```

Get root from personal space

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\MeDriveRootApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->homeGetRoot();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MeDriveRootApi->homeGetRoot: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\DriveItem**](../Model/DriveItem.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
