# OpenAPI\Client\EducationSchoolApi

All URIs are relative to https://ocis.ocis-traefik.latest.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**addClassToSchool()**](EducationSchoolApi.md#addClassToSchool) | **POST** /v1.0/education/schools/{school-id}/classes/$ref | Assign a class to a school |
| [**addUserToSchool()**](EducationSchoolApi.md#addUserToSchool) | **POST** /v1.0/education/schools/{school-id}/users/$ref | Assign a user to a school |
| [**createSchool()**](EducationSchoolApi.md#createSchool) | **POST** /v1.0/education/schools | Add new school |
| [**deleteClassFromSchool()**](EducationSchoolApi.md#deleteClassFromSchool) | **DELETE** /v1.0/education/schools/{school-id}/classes/{class-id}/$ref | Unassign class from a school |
| [**deleteSchool()**](EducationSchoolApi.md#deleteSchool) | **DELETE** /v1.0/education/schools/{school-id} | Delete school |
| [**deleteUserFromSchool()**](EducationSchoolApi.md#deleteUserFromSchool) | **DELETE** /v1.0/education/schools/{school-id}/users/{user-id}/$ref | Unassign user from a school |
| [**getSchool()**](EducationSchoolApi.md#getSchool) | **GET** /v1.0/education/schools/{school-id} | Get the properties of a specific school |
| [**listSchoolClasses()**](EducationSchoolApi.md#listSchoolClasses) | **GET** /v1.0/education/schools/{school-id}/classes | Get the educationClass resources owned by an educationSchool |
| [**listSchoolUsers()**](EducationSchoolApi.md#listSchoolUsers) | **GET** /v1.0/education/schools/{school-id}/users | Get the educationUser resources associated with an educationSchool |
| [**listSchools()**](EducationSchoolApi.md#listSchools) | **GET** /v1.0/education/schools | Get a list of schools and their properties |
| [**updateSchool()**](EducationSchoolApi.md#updateSchool) | **PATCH** /v1.0/education/schools/{school-id} | Update properties of a school |


## `addClassToSchool()`

```php
addClassToSchool($school_id, $class_reference)
```

Assign a class to a school

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationSchoolApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$school_id = 43b879c4-14c6-4e0a-9b3f-b1b33c5a4bd4; // string | key: id or schoolNumber of school
$class_reference = new \OpenAPI\Client\Model\ClassReference(); // \OpenAPI\Client\Model\ClassReference | educationClass to be added as member

try {
    $apiInstance->addClassToSchool($school_id, $class_reference);
} catch (Exception $e) {
    echo 'Exception when calling EducationSchoolApi->addClassToSchool: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **school_id** | **string**| key: id or schoolNumber of school | |
| **class_reference** | [**\OpenAPI\Client\Model\ClassReference**](../Model/ClassReference.md)| educationClass to be added as member | |

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

## `addUserToSchool()`

```php
addUserToSchool($school_id, $education_user_reference)
```

Assign a user to a school

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationSchoolApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$school_id = 43b879c4-14c6-4e0a-9b3f-b1b33c5a4bd4; // string | key: id or schoolNumber of school
$education_user_reference = new \OpenAPI\Client\Model\EducationUserReference(); // \OpenAPI\Client\Model\EducationUserReference | educationUser to be added as member

try {
    $apiInstance->addUserToSchool($school_id, $education_user_reference);
} catch (Exception $e) {
    echo 'Exception when calling EducationSchoolApi->addUserToSchool: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **school_id** | **string**| key: id or schoolNumber of school | |
| **education_user_reference** | [**\OpenAPI\Client\Model\EducationUserReference**](../Model/EducationUserReference.md)| educationUser to be added as member | |

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

## `createSchool()`

```php
createSchool($education_school): \OpenAPI\Client\Model\EducationSchool
```

Add new school

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationSchoolApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$education_school = new \OpenAPI\Client\Model\EducationSchool(); // \OpenAPI\Client\Model\EducationSchool | New school

try {
    $result = $apiInstance->createSchool($education_school);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationSchoolApi->createSchool: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **education_school** | [**\OpenAPI\Client\Model\EducationSchool**](../Model/EducationSchool.md)| New school | |

### Return type

[**\OpenAPI\Client\Model\EducationSchool**](../Model/EducationSchool.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteClassFromSchool()`

```php
deleteClassFromSchool($school_id, $class_id)
```

Unassign class from a school

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationSchoolApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$school_id = 43b879c4-14c6-4e0a-9b3f-b1b33c5a4bd4; // string | key: id or schoolNumber of school
$class_id = 7e84a069-f374-479b-817d-71590117d443; // string | key: id or externalId of the class to unassign from school

try {
    $apiInstance->deleteClassFromSchool($school_id, $class_id);
} catch (Exception $e) {
    echo 'Exception when calling EducationSchoolApi->deleteClassFromSchool: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **school_id** | **string**| key: id or schoolNumber of school | |
| **class_id** | **string**| key: id or externalId of the class to unassign from school | |

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

## `deleteSchool()`

```php
deleteSchool($school_id)
```

Delete school

Deletes a school. A school can only be delete if it has the terminationDate property set. And if that termination Date is in the past.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationSchoolApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$school_id = 43b879c4-14c6-4e0a-9b3f-b1b33c5a4bd4; // string | key: id or schoolNumber of school

try {
    $apiInstance->deleteSchool($school_id);
} catch (Exception $e) {
    echo 'Exception when calling EducationSchoolApi->deleteSchool: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **school_id** | **string**| key: id or schoolNumber of school | |

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

## `deleteUserFromSchool()`

```php
deleteUserFromSchool($school_id, $user_id)
```

Unassign user from a school

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationSchoolApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$school_id = 43b879c4-14c6-4e0a-9b3f-b1b33c5a4bd4; // string | key: id or schoolNumber of school
$user_id = 90eedea1-dea1-90ee-a1de-ee90a1deee90; // string | key: id or username of the user to unassign from school

try {
    $apiInstance->deleteUserFromSchool($school_id, $user_id);
} catch (Exception $e) {
    echo 'Exception when calling EducationSchoolApi->deleteUserFromSchool: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **school_id** | **string**| key: id or schoolNumber of school | |
| **user_id** | **string**| key: id or username of the user to unassign from school | |

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

## `getSchool()`

```php
getSchool($school_id): \OpenAPI\Client\Model\EducationSchool
```

Get the properties of a specific school

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationSchoolApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$school_id = 43b879c4-14c6-4e0a-9b3f-b1b33c5a4bd4; // string | key: id or schoolNumber of school

try {
    $result = $apiInstance->getSchool($school_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationSchoolApi->getSchool: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **school_id** | **string**| key: id or schoolNumber of school | |

### Return type

[**\OpenAPI\Client\Model\EducationSchool**](../Model/EducationSchool.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listSchoolClasses()`

```php
listSchoolClasses($school_id): \OpenAPI\Client\Model\CollectionOfEducationClass
```

Get the educationClass resources owned by an educationSchool

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationSchoolApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$school_id = 43b879c4-14c6-4e0a-9b3f-b1b33c5a4bd4; // string | key: id or schoolNumber of school

try {
    $result = $apiInstance->listSchoolClasses($school_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationSchoolApi->listSchoolClasses: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **school_id** | **string**| key: id or schoolNumber of school | |

### Return type

[**\OpenAPI\Client\Model\CollectionOfEducationClass**](../Model/CollectionOfEducationClass.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listSchoolUsers()`

```php
listSchoolUsers($school_id): \OpenAPI\Client\Model\CollectionOfEducationUser
```

Get the educationUser resources associated with an educationSchool

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationSchoolApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$school_id = 43b879c4-14c6-4e0a-9b3f-b1b33c5a4bd4; // string | key: id or schoolNumber of school

try {
    $result = $apiInstance->listSchoolUsers($school_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationSchoolApi->listSchoolUsers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **school_id** | **string**| key: id or schoolNumber of school | |

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

## `listSchools()`

```php
listSchools(): \OpenAPI\Client\Model\CollectionOfSchools
```

Get a list of schools and their properties

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationSchoolApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->listSchools();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationSchoolApi->listSchools: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\CollectionOfSchools**](../Model/CollectionOfSchools.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateSchool()`

```php
updateSchool($school_id, $education_school): \OpenAPI\Client\Model\EducationSchool
```

Update properties of a school

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationSchoolApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$school_id = 43b879c4-14c6-4e0a-9b3f-b1b33c5a4bd4; // string | key: id or schoolNumber of school
$education_school = new \OpenAPI\Client\Model\EducationSchool(); // \OpenAPI\Client\Model\EducationSchool | New property values

try {
    $result = $apiInstance->updateSchool($school_id, $education_school);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationSchoolApi->updateSchool: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **school_id** | **string**| key: id or schoolNumber of school | |
| **education_school** | [**\OpenAPI\Client\Model\EducationSchool**](../Model/EducationSchool.md)| New property values | |

### Return type

[**\OpenAPI\Client\Model\EducationSchool**](../Model/EducationSchool.md)

### Authorization

[bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
