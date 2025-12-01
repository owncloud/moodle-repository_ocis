# OpenAPI\Client\DrivesApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createDrive()**](DrivesApi.md#createDrive) | **POST** /v1.0/drives | Create a new drive of a specific type |
| [**deleteDrive()**](DrivesApi.md#deleteDrive) | **DELETE** /v1.0/drives/{drive-id} | Delete a specific space |
| [**getDrive()**](DrivesApi.md#getDrive) | **GET** /v1.0/drives/{drive-id} | Get drive by id |
| [**updateDrive()**](DrivesApi.md#updateDrive) | **PATCH** /v1.0/drives/{drive-id} | Update the drive |


## `createDrive()`

```php
createDrive($drive): \OpenAPI\Client\Model\Drive
```

Create a new drive of a specific type

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive = {"name":"Mars","quota":{"total":1000000000},"description":"Team space mars project"}; // \OpenAPI\Client\Model\Drive | New space property values

try {
    $result = $apiInstance->createDrive($drive);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesApi->createDrive: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive** | [**\OpenAPI\Client\Model\Drive**](../Model/Drive.md)| New space property values | |

### Return type

[**\OpenAPI\Client\Model\Drive**](../Model/Drive.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteDrive()`

```php
deleteDrive($drive_id, $if_match)
```

Delete a specific space

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$if_match = 'if_match_example'; // string | ETag

try {
    $apiInstance->deleteDrive($drive_id, $if_match);
} catch (Exception $e) {
    echo 'Exception when calling DrivesApi->deleteDrive: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **if_match** | **string**| ETag | [optional] |

### Return type

void (empty response body)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getDrive()`

```php
getDrive($drive_id): \OpenAPI\Client\Model\Drive
```

Get drive by id

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive

try {
    $result = $apiInstance->getDrive($drive_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesApi->getDrive: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |

### Return type

[**\OpenAPI\Client\Model\Drive**](../Model/Drive.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateDrive()`

```php
updateDrive($drive_id, $drive_update): \OpenAPI\Client\Model\Drive
```

Update the drive

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$drive_update = {"quota":{"total":1000000000}}; // \OpenAPI\Client\Model\DriveUpdate | New space values

try {
    $result = $apiInstance->updateDrive($drive_id, $drive_update);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesApi->updateDrive: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **drive_update** | [**\OpenAPI\Client\Model\DriveUpdate**](../Model/DriveUpdate.md)| New space values | |

### Return type

[**\OpenAPI\Client\Model\Drive**](../Model/Drive.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
