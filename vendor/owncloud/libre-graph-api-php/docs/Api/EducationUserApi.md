# OpenAPI\Client\EducationUserApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createEducationUser()**](EducationUserApi.md#createEducationUser) | **POST** /v1.0/education/users | Add new education user |
| [**deleteEducationUser()**](EducationUserApi.md#deleteEducationUser) | **DELETE** /v1.0/education/users/{user-id} | Delete educationUser |
| [**getEducationUser()**](EducationUserApi.md#getEducationUser) | **GET** /v1.0/education/users/{user-id} | Get properties of educationUser |
| [**listEducationUsers()**](EducationUserApi.md#listEducationUsers) | **GET** /v1.0/education/users | Get entities from education users |
| [**updateEducationUser()**](EducationUserApi.md#updateEducationUser) | **PATCH** /v1.0/education/users/{user-id} | Update properties of educationUser |


## `createEducationUser()`

```php
createEducationUser($education_user): \OpenAPI\Client\Model\EducationUser
```

Add new education user

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationUserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$education_user = new \OpenAPI\Client\Model\EducationUser(); // \OpenAPI\Client\Model\EducationUser | New entity

try {
    $result = $apiInstance->createEducationUser($education_user);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationUserApi->createEducationUser: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **education_user** | [**\OpenAPI\Client\Model\EducationUser**](../Model/EducationUser.md)| New entity | |

### Return type

[**\OpenAPI\Client\Model\EducationUser**](../Model/EducationUser.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteEducationUser()`

```php
deleteEducationUser($user_id)
```

Delete educationUser

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationUserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 90eedea1-dea1-90ee-a1de-ee90a1deee90; // string | key: id or username of user

try {
    $apiInstance->deleteEducationUser($user_id);
} catch (Exception $e) {
    echo 'Exception when calling EducationUserApi->deleteEducationUser: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user_id** | **string**| key: id or username of user | |

### Return type

void (empty response body)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getEducationUser()`

```php
getEducationUser($user_id, $expand): \OpenAPI\Client\Model\EducationUser
```

Get properties of educationUser

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationUserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 90eedea1-dea1-90ee-a1de-ee90a1deee90; // string | key: id or username of user
$expand = array('expand_example'); // string[] | Expand related entities

try {
    $result = $apiInstance->getEducationUser($user_id, $expand);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationUserApi->getEducationUser: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user_id** | **string**| key: id or username of user | |
| **expand** | [**string[]**](../Model/string.md)| Expand related entities | [optional] |

### Return type

[**\OpenAPI\Client\Model\EducationUser**](../Model/EducationUser.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listEducationUsers()`

```php
listEducationUsers($orderby, $expand): \OpenAPI\Client\Model\CollectionOfEducationUser
```

Get entities from education users

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationUserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$orderby = array('orderby_example'); // string[] | Order items by property values
$expand = array('expand_example'); // string[] | Expand related entities

try {
    $result = $apiInstance->listEducationUsers($orderby, $expand);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationUserApi->listEducationUsers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **orderby** | [**string[]**](../Model/string.md)| Order items by property values | [optional] |
| **expand** | [**string[]**](../Model/string.md)| Expand related entities | [optional] |

### Return type

[**\OpenAPI\Client\Model\CollectionOfEducationUser**](../Model/CollectionOfEducationUser.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateEducationUser()`

```php
updateEducationUser($user_id, $education_user): \OpenAPI\Client\Model\EducationUser
```

Update properties of educationUser

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationUserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 90eedea1-dea1-90ee-a1de-ee90a1deee90; // string | key: id or username of user
$education_user = {"mail":"max.mustermann@new.domain"}; // \OpenAPI\Client\Model\EducationUser | New property values

try {
    $result = $apiInstance->updateEducationUser($user_id, $education_user);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationUserApi->updateEducationUser: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user_id** | **string**| key: id or username of user | |
| **education_user** | [**\OpenAPI\Client\Model\EducationUser**](../Model/EducationUser.md)| New property values | |

### Return type

[**\OpenAPI\Client\Model\EducationUser**](../Model/EducationUser.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
