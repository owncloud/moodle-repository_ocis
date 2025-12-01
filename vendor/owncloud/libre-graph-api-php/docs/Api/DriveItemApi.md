# OpenAPI\Client\DriveItemApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**deleteDriveItem()**](DriveItemApi.md#deleteDriveItem) | **DELETE** /v1beta1/drives/{drive-id}/items/{item-id} | Delete a DriveItem. |
| [**getDriveItem()**](DriveItemApi.md#getDriveItem) | **GET** /v1beta1/drives/{drive-id}/items/{item-id} | Get a DriveItem. |
| [**updateDriveItem()**](DriveItemApi.md#updateDriveItem) | **PATCH** /v1beta1/drives/{drive-id}/items/{item-id} | Update a DriveItem. |


## `deleteDriveItem()`

```php
deleteDriveItem($drive_id, $item_id)
```

Delete a DriveItem.

Delete a DriveItem by using its ID.  Deleting items using this method moves the items to the recycle bin instead of permanently deleting the item.  Mounted shares in the share jail are unmounted. The `@client.synchronize` property of the `driveItem` in the [sharedWithMe](#/me.drive/ListSharedWithMe) endpoint will change to false.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DriveItemApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = a0ca6a90-a365-4782-871e-d44447bbc668$a0ca6a90-a365-4782-871e-d44447bbc668; // string | key: id of drive
$item_id = a0ca6a90-a365-4782-871e-d44447bbc668$a0ca6a90-a365-4782-871e-d44447bbc668!share-id; // string | key: id of item

try {
    $apiInstance->deleteDriveItem($drive_id, $item_id);
} catch (Exception $e) {
    echo 'Exception when calling DriveItemApi->deleteDriveItem: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **item_id** | **string**| key: id of item | |

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

## `getDriveItem()`

```php
getDriveItem($drive_id, $item_id): \OpenAPI\Client\Model\DriveItem
```

Get a DriveItem.

Get a DriveItem by using its ID.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DriveItemApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = a0ca6a90-a365-4782-871e-d44447bbc668$a0ca6a90-a365-4782-871e-d44447bbc668; // string | key: id of drive
$item_id = a0ca6a90-a365-4782-871e-d44447bbc668$a0ca6a90-a365-4782-871e-d44447bbc668!share-id; // string | key: id of item

try {
    $result = $apiInstance->getDriveItem($drive_id, $item_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DriveItemApi->getDriveItem: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **item_id** | **string**| key: id of item | |

### Return type

[**\OpenAPI\Client\Model\DriveItem**](../Model/DriveItem.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateDriveItem()`

```php
updateDriveItem($drive_id, $item_id, $drive_item): \OpenAPI\Client\Model\DriveItem
```

Update a DriveItem.

Update a DriveItem.  The request body must include a JSON object with the properties to update. Only the properties that are provided will be updated.  Currently it supports updating the following properties:  * `@UI.Hidden` - Hides the item from the UI.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DriveItemApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = a0ca6a90-a365-4782-871e-d44447bbc668$a0ca6a90-a365-4782-871e-d44447bbc668; // string | key: id of drive
$item_id = a0ca6a90-a365-4782-871e-d44447bbc668$a0ca6a90-a365-4782-871e-d44447bbc668!share-id; // string | key: id of item
$drive_item = {"@UI.Hidden":true}; // \OpenAPI\Client\Model\DriveItem | DriveItem properties to update

try {
    $result = $apiInstance->updateDriveItem($drive_id, $item_id, $drive_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DriveItemApi->updateDriveItem: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **item_id** | **string**| key: id of item | |
| **drive_item** | [**\OpenAPI\Client\Model\DriveItem**](../Model/DriveItem.md)| DriveItem properties to update | |

### Return type

[**\OpenAPI\Client\Model\DriveItem**](../Model/DriveItem.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
