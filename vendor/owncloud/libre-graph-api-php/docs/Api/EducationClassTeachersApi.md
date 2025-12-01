# OpenAPI\Client\EducationClassTeachersApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**addTeacherToClass()**](EducationClassTeachersApi.md#addTeacherToClass) | **POST** /v1.0/education/classes/{class-id}/teachers/$ref | Assign a teacher to a class |
| [**deleteTeacherFromClass()**](EducationClassTeachersApi.md#deleteTeacherFromClass) | **DELETE** /v1.0/education/classes/{class-id}/teachers/{user-id}/$ref | Unassign user as teacher of a class |
| [**getTeachers()**](EducationClassTeachersApi.md#getTeachers) | **GET** /v1.0/education/classes/{class-id}/teachers | Get the teachers for a class |


## `addTeacherToClass()`

```php
addTeacherToClass($class_id, $class_teacher_reference)
```

Assign a teacher to a class

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationClassTeachersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$class_id = 86948e45-96a6-43df-b83d-46e92afd30de; // string | key: id or externalId of class
$class_teacher_reference = new \OpenAPI\Client\Model\ClassTeacherReference(); // \OpenAPI\Client\Model\ClassTeacherReference | educationUser to be added as teacher

try {
    $apiInstance->addTeacherToClass($class_id, $class_teacher_reference);
} catch (Exception $e) {
    echo 'Exception when calling EducationClassTeachersApi->addTeacherToClass: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **class_id** | **string**| key: id or externalId of class | |
| **class_teacher_reference** | [**\OpenAPI\Client\Model\ClassTeacherReference**](../Model/ClassTeacherReference.md)| educationUser to be added as teacher | |

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

## `deleteTeacherFromClass()`

```php
deleteTeacherFromClass($class_id, $user_id)
```

Unassign user as teacher of a class

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationClassTeachersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$class_id = 'class_id_example'; // string | key: id or externalId of class
$user_id = 90eedea1-dea1-90ee-a1de-ee90a1deee90; // string | key: id or username of the user to unassign as teacher

try {
    $apiInstance->deleteTeacherFromClass($class_id, $user_id);
} catch (Exception $e) {
    echo 'Exception when calling EducationClassTeachersApi->deleteTeacherFromClass: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **class_id** | **string**| key: id or externalId of class | |
| **user_id** | **string**| key: id or username of the user to unassign as teacher | |

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

## `getTeachers()`

```php
getTeachers($class_id): \OpenAPI\Client\Model\CollectionOfEducationUser
```

Get the teachers for a class

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (plain) authorization: bearerAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new OpenAPI\Client\Api\EducationClassTeachersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$class_id = 86948e45-96a6-43df-b83d-46e92afd30de; // string | key: id or externalId of class

try {
    $result = $apiInstance->getTeachers($class_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EducationClassTeachersApi->getTeachers: ', $e->getMessage(), PHP_EOL;
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
