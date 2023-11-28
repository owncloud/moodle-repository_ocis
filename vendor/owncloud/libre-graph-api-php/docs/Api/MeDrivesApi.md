# OpenAPI\Client\MeDrivesApi

All URIs are relative to https://ocis.ocis-traefik.latest.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**listMyDrives()**](MeDrivesApi.md#listMyDrives) | **GET** /v1.0/me/drives | Get all drives where the current user is a regular member of |


## `listMyDrives()`

```php
listMyDrives($orderby, $filter): \OpenAPI\Client\Model\CollectionOfDrives
```

Get all drives where the current user is a regular member of

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\MeDrivesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$orderby = lastModifiedDateTime desc; // string | The $orderby system query option allows clients to request resources in either ascending order using asc or descending order using desc.
$filter = driveType eq 'project'; // string | Filter items by property values

try {
    $result = $apiInstance->listMyDrives($orderby, $filter);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MeDrivesApi->listMyDrives: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **orderby** | **string**| The $orderby system query option allows clients to request resources in either ascending order using asc or descending order using desc. | [optional] |
| **filter** | **string**| Filter items by property values | [optional] |

### Return type

[**\OpenAPI\Client\Model\CollectionOfDrives**](../Model/CollectionOfDrives.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
