# OpenAPI\Client\MeDriveApi

All URIs are relative to https://ocis.ocis-traefik.latest.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getHome()**](MeDriveApi.md#getHome) | **GET** /v1.0/me/drive | Get personal space for user |
| [**listSharedByMe()**](MeDriveApi.md#listSharedByMe) | **GET** /v1beta1/me/drive/sharedByMe | Get a list of driveItem objects shared by the current user. |
| [**listSharedWithMe()**](MeDriveApi.md#listSharedWithMe) | **GET** /v1beta1/me/drive/sharedWithMe | Get a list of driveItem objects shared with the owner of a drive. |


## `getHome()`

```php
getHome(): \OpenAPI\Client\Model\Drive
```

Get personal space for user

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\MeDriveApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->getHome();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MeDriveApi->getHome: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\Drive**](../Model/Drive.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listSharedByMe()`

```php
listSharedByMe(): \OpenAPI\Client\Model\CollectionOfDriveItems1
```

Get a list of driveItem objects shared by the current user.

The `driveItems` returned from the `sharedByMe` method always include the `permissions` relation that indicates they are shared items.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\MeDriveApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->listSharedByMe();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MeDriveApi->listSharedByMe: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\CollectionOfDriveItems1**](../Model/CollectionOfDriveItems1.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listSharedWithMe()`

```php
listSharedWithMe(): \OpenAPI\Client\Model\CollectionOfDriveItems1
```

Get a list of driveItem objects shared with the owner of a drive.

The `driveItems` returned from the `sharedWithMe` method always include the `remoteItem` facet that indicates they are items from a different drive.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\MeDriveApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->listSharedWithMe();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MeDriveApi->listSharedWithMe: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\CollectionOfDriveItems1**](../Model/CollectionOfDriveItems1.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
