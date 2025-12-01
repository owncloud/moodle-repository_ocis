# OpenAPI\Client\UsersApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createUser()**](UsersApi.md#createUser) | **POST** /v1.0/users | Add new entity to users |
| [**listUsers()**](UsersApi.md#listUsers) | **GET** /v1.0/users | Get entities from users |


## `createUser()`

```php
createUser($user): \OpenAPI\Client\Model\User
```

Add new entity to users

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user = new \OpenAPI\Client\Model\User(); // \OpenAPI\Client\Model\User | New entity

try {
    $result = $apiInstance->createUser($user);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->createUser: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user** | [**\OpenAPI\Client\Model\User**](../Model/User.md)| New entity | |

### Return type

[**\OpenAPI\Client\Model\User**](../Model/User.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listUsers()`

```php
listUsers($search, $filter, $orderby, $select, $expand): \OpenAPI\Client\Model\CollectionOfUser
```

Get entities from users

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$search = 'search_example'; // string | Search items by search phrases
$filter = memberOf/any(x:x/id eq 910367f9-4041-4db1-961b-d1e98f708eaf); // string | Filter users by property values and relationship attributes
$orderby = array('orderby_example'); // string[] | Order items by property values
$select = array('select_example'); // string[] | Select properties to be returned
$expand = array('expand_example'); // string[] | Expand related entities

try {
    $result = $apiInstance->listUsers($search, $filter, $orderby, $select, $expand);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->listUsers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **search** | **string**| Search items by search phrases | [optional] |
| **filter** | **string**| Filter users by property values and relationship attributes | [optional] |
| **orderby** | [**string[]**](../Model/string.md)| Order items by property values | [optional] |
| **select** | [**string[]**](../Model/string.md)| Select properties to be returned | [optional] |
| **expand** | [**string[]**](../Model/string.md)| Expand related entities | [optional] |

### Return type

[**\OpenAPI\Client\Model\CollectionOfUser**](../Model/CollectionOfUser.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
