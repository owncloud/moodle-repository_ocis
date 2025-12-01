# OpenAPI\Client\RoleManagementApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getPermissionRoleDefinition()**](RoleManagementApi.md#getPermissionRoleDefinition) | **GET** /v1beta1/roleManagement/permissions/roleDefinitions/{role-id} | Get unifiedRoleDefinition |
| [**listPermissionRoleDefinitions()**](RoleManagementApi.md#listPermissionRoleDefinitions) | **GET** /v1beta1/roleManagement/permissions/roleDefinitions | List roleDefinitions |


## `getPermissionRoleDefinition()`

```php
getPermissionRoleDefinition($role_id): \OpenAPI\Client\Model\UnifiedRoleDefinition
```

Get unifiedRoleDefinition

Read the properties and relationships of a `unifiedRoleDefinition` object.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\RoleManagementApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$role_id = 'role_id_example'; // string | key: id of roleDefinition

try {
    $result = $apiInstance->getPermissionRoleDefinition($role_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RoleManagementApi->getPermissionRoleDefinition: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **role_id** | **string**| key: id of roleDefinition | |

### Return type

[**\OpenAPI\Client\Model\UnifiedRoleDefinition**](../Model/UnifiedRoleDefinition.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listPermissionRoleDefinitions()`

```php
listPermissionRoleDefinitions(): \OpenAPI\Client\Model\UnifiedRoleDefinition
```

List roleDefinitions

Get a list of `unifiedRoleDefinition` objects for the permissions provider. This list determines the roles that can be selected when creating sharing invites.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\RoleManagementApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->listPermissionRoleDefinitions();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RoleManagementApi->listPermissionRoleDefinitions: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\UnifiedRoleDefinition**](../Model/UnifiedRoleDefinition.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
