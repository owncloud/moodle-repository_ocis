# OpenAPI\Client\GroupsApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createGroup()**](GroupsApi.md#createGroup) | **POST** /v1.0/groups | Add new entity to groups |
| [**listGroups()**](GroupsApi.md#listGroups) | **GET** /v1.0/groups | Get entities from groups |


## `createGroup()`

```php
createGroup($group): \OpenAPI\Client\Model\Group
```

Add new entity to groups

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\GroupsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$group = new \OpenAPI\Client\Model\Group(); // \OpenAPI\Client\Model\Group | New entity

try {
    $result = $apiInstance->createGroup($group);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GroupsApi->createGroup: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **group** | [**\OpenAPI\Client\Model\Group**](../Model/Group.md)| New entity | |

### Return type

[**\OpenAPI\Client\Model\Group**](../Model/Group.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listGroups()`

```php
listGroups($search, $orderby, $select, $expand): \OpenAPI\Client\Model\CollectionOfGroup
```

Get entities from groups

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\GroupsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = 'search_example'; // string | Search items by search phrases
$orderby = array('orderby_example'); // string[] | Order items by property values
$select = array('select_example'); // string[] | Select properties to be returned
$expand = array('expand_example'); // string[] | Expand related entities

try {
    $result = $apiInstance->listGroups($search, $orderby, $select, $expand);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GroupsApi->listGroups: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Search items by search phrases | [optional] |
| **orderby** | [**string[]**](../Model/string.md)| Order items by property values | [optional] |
| **select** | [**string[]**](../Model/string.md)| Select properties to be returned | [optional] |
| **expand** | [**string[]**](../Model/string.md)| Expand related entities | [optional] |

### Return type

[**\OpenAPI\Client\Model\CollectionOfGroup**](../Model/CollectionOfGroup.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
