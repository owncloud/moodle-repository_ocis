# OpenAPI\Client\TagsApi

All URIs are relative to https://ocis.ocis-traefik.latest.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**assignTags()**](TagsApi.md#assignTags) | **PUT** /v1.0/extensions/org.libregraph/tags | Assign tags to a resource |
| [**getTags()**](TagsApi.md#getTags) | **GET** /v1.0/extensions/org.libregraph/tags | Get all known tags |
| [**unassignTags()**](TagsApi.md#unassignTags) | **DELETE** /v1.0/extensions/org.libregraph/tags | Unassign tags from a resource |


## `assignTags()`

```php
assignTags($tag_assignment)
```

Assign tags to a resource

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\TagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$tag_assignment = new \OpenAPI\Client\Model\TagAssignment(); // \OpenAPI\Client\Model\TagAssignment

try {
    $apiInstance->assignTags($tag_assignment);
} catch (Exception $e) {
    echo 'Exception when calling TagsApi->assignTags: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **tag_assignment** | [**\OpenAPI\Client\Model\TagAssignment**](../Model/TagAssignment.md)|  | [optional] |

### Return type

void (empty response body)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getTags()`

```php
getTags(): \OpenAPI\Client\Model\CollectionOfTags
```

Get all known tags

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\TagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->getTags();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TagsApi->getTags: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\CollectionOfTags**](../Model/CollectionOfTags.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `unassignTags()`

```php
unassignTags($tag_unassignment)
```

Unassign tags from a resource

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\TagsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$tag_unassignment = new \OpenAPI\Client\Model\TagUnassignment(); // \OpenAPI\Client\Model\TagUnassignment

try {
    $apiInstance->unassignTags($tag_unassignment);
} catch (Exception $e) {
    echo 'Exception when calling TagsApi->unassignTags: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **tag_unassignment** | [**\OpenAPI\Client\Model\TagUnassignment**](../Model/TagUnassignment.md)|  | [optional] |

### Return type

void (empty response body)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
