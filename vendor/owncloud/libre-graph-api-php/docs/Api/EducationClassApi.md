# OpenAPI\Client\EducationClassApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**addUserToClass()**](EducationClassApi.md#addUserToClass) | **POST** /v1.0/education/classes/{class-id}/members/$ref | Assign a user to a class |
| [**createClass()**](EducationClassApi.md#createClass) | **POST** /v1.0/education/classes | Add new education class |
| [**deleteClass()**](EducationClassApi.md#deleteClass) | **DELETE** /v1.0/education/classes/{class-id} | Delete education class |
| [**deleteUserFromClass()**](EducationClassApi.md#deleteUserFromClass) | **DELETE** /v1.0/education/classes/{class-id}/members/{user-id}/$ref | Unassign user from a class |
| [**getClass()**](EducationClassApi.md#getClass) | **GET** /v1.0/education/classes/{class-id} | Get class by key |
| [**listClassMembers()**](EducationClassApi.md#listClassMembers) | **GET** /v1.0/education/classes/{class-id}/members | Get the educationClass resources owned by an educationSchool |
| [**listClasses()**](EducationClassApi.md#listClasses) | **GET** /v1.0/education/classes | list education classes |
| [**updateClass()**](EducationClassApi.md#updateClass) | **PATCH** /v1.0/education/classes/{class-id} | Update properties of a education class |


## `addUserToClass()`

```php
addUserToClass($class_id, $class_member_reference)
```

Assign a user to a class

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationClassApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$class_id = 86948e45-96a6-43df-b83d-46e92afd30de; // string | key: id or externalId of class
$class_member_reference = new \OpenAPI\Client\Model\ClassMemberReference(); // \OpenAPI\Client\Model\ClassMemberReference | educationUser to be added as member

try {
    $apiInstance->addUserToClass($class_id, $class_member_reference);
} catch (Exception $e) {
    echo 'Exception when calling EducationClassApi->addUserToClass: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **class_id** | **string**| key: id or externalId of class | |
| **class_member_reference** | [**\OpenAPI\Client\Model\ClassMemberReference**](../Model/ClassMemberReference.md)| educationUser to be added as member | |

### Return type

void (empty response body)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `createClass()`

```php
createClass($education_class): \OpenAPI\Client\Model\EducationClass
```

Add new education class

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationClassApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$education_class = new \OpenAPI\Client\Model\EducationClass(); // \OpenAPI\Client\Model\EducationClass | New entity

try {
    $result = $apiInstance->createClass($education_class);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationClassApi->createClass: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **education_class** | [**\OpenAPI\Client\Model\EducationClass**](../Model/EducationClass.md)| New entity | |

### Return type

[**\OpenAPI\Client\Model\EducationClass**](../Model/EducationClass.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteClass()`

```php
deleteClass($class_id)
```

Delete education class

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationClassApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$class_id = 86948e45-96a6-43df-b83d-46e92afd30de; // string | key: id or externalId of class

try {
    $apiInstance->deleteClass($class_id);
} catch (Exception $e) {
    echo 'Exception when calling EducationClassApi->deleteClass: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **class_id** | **string**| key: id or externalId of class | |

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

## `deleteUserFromClass()`

```php
deleteUserFromClass($class_id, $user_id)
```

Unassign user from a class

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationClassApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$class_id = 'class_id_example'; // string | key: id or externalId of class
$user_id = 90eedea1-dea1-90ee-a1de-ee90a1deee90; // string | key: id or username of the user to unassign from class

try {
    $apiInstance->deleteUserFromClass($class_id, $user_id);
} catch (Exception $e) {
    echo 'Exception when calling EducationClassApi->deleteUserFromClass: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **class_id** | **string**| key: id or externalId of class | |
| **user_id** | **string**| key: id or username of the user to unassign from class | |

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

## `getClass()`

```php
getClass($class_id): \OpenAPI\Client\Model\EducationClass
```

Get class by key

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationClassApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$class_id = 86948e45-96a6-43df-b83d-46e92afd30de; // string | key: id or externalId of class

try {
    $result = $apiInstance->getClass($class_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationClassApi->getClass: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **class_id** | **string**| key: id or externalId of class | |

### Return type

[**\OpenAPI\Client\Model\EducationClass**](../Model/EducationClass.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listClassMembers()`

```php
listClassMembers($class_id): \OpenAPI\Client\Model\CollectionOfEducationUser
```

Get the educationClass resources owned by an educationSchool

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationClassApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$class_id = 86948e45-96a6-43df-b83d-46e92afd30de; // string | key: id or externalId of class

try {
    $result = $apiInstance->listClassMembers($class_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationClassApi->listClassMembers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **class_id** | **string**| key: id or externalId of class | |

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

## `listClasses()`

```php
listClasses(): \OpenAPI\Client\Model\CollectionOfClass
```

list education classes

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationClassApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->listClasses();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationClassApi->listClasses: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\CollectionOfClass**](../Model/CollectionOfClass.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateClass()`

```php
updateClass($class_id, $education_class): \OpenAPI\Client\Model\EducationClass
```

Update properties of a education class

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationClassApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$class_id = 86948e45-96a6-43df-b83d-46e92afd30de; // string | key: id or externalId of class
$education_class = {"displayName":"Musik"}; // \OpenAPI\Client\Model\EducationClass | New property values

try {
    $result = $apiInstance->updateClass($class_id, $education_class);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationClassApi->updateClass: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **class_id** | **string**| key: id or externalId of class | |
| **education_class** | [**\OpenAPI\Client\Model\EducationClass**](../Model/EducationClass.md)| New property values | |

### Return type

[**\OpenAPI\Client\Model\EducationClass**](../Model/EducationClass.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
