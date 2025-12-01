# OpenAPI\Client\UserApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**deleteUser()**](UserApi.md#deleteUser) | **DELETE** /v1.0/users/{user-id} | Delete entity from users |
| [**exportPersonalData()**](UserApi.md#exportPersonalData) | **POST** /v1.0/users/{user-id}/exportPersonalData | export personal data of a user |
| [**getUser()**](UserApi.md#getUser) | **GET** /v1.0/users/{user-id} | Get entity from users by key |
| [**updateUser()**](UserApi.md#updateUser) | **PATCH** /v1.0/users/{user-id} | Update entity in users |


## `deleteUser()`

```php
deleteUser($user_id, $if_match)
```

Delete entity from users

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\UserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 'user_id_example'; // string | key: id or name of user
$if_match = 'if_match_example'; // string | ETag

try {
    $apiInstance->deleteUser($user_id, $if_match);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->deleteUser: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user_id** | **string**| key: id or name of user | |
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

## `exportPersonalData()`

```php
exportPersonalData($user_id, $export_personal_data_request)
```

export personal data of a user

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\UserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 'user_id_example'; // string | key: id or name of user
$export_personal_data_request = new \OpenAPI\Client\Model\ExportPersonalDataRequest(); // \OpenAPI\Client\Model\ExportPersonalDataRequest | destination the file should be created at

try {
    $apiInstance->exportPersonalData($user_id, $export_personal_data_request);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->exportPersonalData: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user_id** | **string**| key: id or name of user | |
| **export_personal_data_request** | [**\OpenAPI\Client\Model\ExportPersonalDataRequest**](../Model/ExportPersonalDataRequest.md)| destination the file should be created at | [optional] |

### Return type

void (empty response body)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getUser()`

```php
getUser($user_id, $select, $expand): \OpenAPI\Client\Model\User
```

Get entity from users by key

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\UserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 'user_id_example'; // string | key: id or name of user
$select = array('select_example'); // string[] | Select properties to be returned
$expand = array('expand_example'); // string[] | Expand related entities

try {
    $result = $apiInstance->getUser($user_id, $select, $expand);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->getUser: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user_id** | **string**| key: id or name of user | |
| **select** | [**string[]**](../Model/string.md)| Select properties to be returned | [optional] |
| **expand** | [**string[]**](../Model/string.md)| Expand related entities | [optional] |

### Return type

[**\OpenAPI\Client\Model\User**](../Model/User.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateUser()`

```php
updateUser($user_id, $user_update): \OpenAPI\Client\Model\User
```

Update entity in users

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\UserApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 'user_id_example'; // string | key: id of user
$user_update = {"displayName":"Marie Skłodowska Curie"}; // \OpenAPI\Client\Model\UserUpdate | New property values

try {
    $result = $apiInstance->updateUser($user_id, $user_update);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserApi->updateUser: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user_id** | **string**| key: id of user | |
| **user_update** | [**\OpenAPI\Client\Model\UserUpdate**](../Model/UserUpdate.md)| New property values | |

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
