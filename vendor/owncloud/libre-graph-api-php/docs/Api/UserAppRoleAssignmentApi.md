# OpenAPI\Client\UserAppRoleAssignmentApi

All URIs are relative to https://ocis.ocis-traefik.latest.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**userCreateAppRoleAssignments()**](UserAppRoleAssignmentApi.md#userCreateAppRoleAssignments) | **POST** /v1.0/users/{user-id}/appRoleAssignments | Grant an appRoleAssignment to a user |
| [**userDeleteAppRoleAssignments()**](UserAppRoleAssignmentApi.md#userDeleteAppRoleAssignments) | **DELETE** /v1.0/users/{user-id}/appRoleAssignments/{appRoleAssignment-id} | Delete the appRoleAssignment from a user |
| [**userListAppRoleAssignments()**](UserAppRoleAssignmentApi.md#userListAppRoleAssignments) | **GET** /v1.0/users/{user-id}/appRoleAssignments | Get appRoleAssignments from a user |


## `userCreateAppRoleAssignments()`

```php
userCreateAppRoleAssignments($user_id, $app_role_assignment): \OpenAPI\Client\Model\AppRoleAssignment
```

Grant an appRoleAssignment to a user

Use this API to assign a global role to a user. To grant an app role assignment to a user, you need three identifiers: * `principalId`: The `id` of the user to whom you are assigning the app role. * `resourceId`: The `id` of the resource `servicePrincipal` or `application` that has defined the app role. * `appRoleId`: The `id` of the `appRole` (defined on the resource service principal or application) to assign to the user.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\UserAppRoleAssignmentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 'user_id_example'; // string | key: id of user
$app_role_assignment = new \OpenAPI\Client\Model\AppRoleAssignment(); // \OpenAPI\Client\Model\AppRoleAssignment | New app role assignment value

try {
    $result = $apiInstance->userCreateAppRoleAssignments($user_id, $app_role_assignment);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserAppRoleAssignmentApi->userCreateAppRoleAssignments: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user_id** | **string**| key: id of user | |
| **app_role_assignment** | [**\OpenAPI\Client\Model\AppRoleAssignment**](../Model/AppRoleAssignment.md)| New app role assignment value | |

### Return type

[**\OpenAPI\Client\Model\AppRoleAssignment**](../Model/AppRoleAssignment.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `userDeleteAppRoleAssignments()`

```php
userDeleteAppRoleAssignments($user_id, $app_role_assignment_id, $if_match)
```

Delete the appRoleAssignment from a user

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\UserAppRoleAssignmentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 'user_id_example'; // string | key: id of user
$app_role_assignment_id = 'app_role_assignment_id_example'; // string | key: id of appRoleAssignment. This is the concatenated {user-id}:{appRole-id} separated by a colon.
$if_match = 'if_match_example'; // string | ETag

try {
    $apiInstance->userDeleteAppRoleAssignments($user_id, $app_role_assignment_id, $if_match);
} catch (Exception $e) {
    echo 'Exception when calling UserAppRoleAssignmentApi->userDeleteAppRoleAssignments: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user_id** | **string**| key: id of user | |
| **app_role_assignment_id** | **string**| key: id of appRoleAssignment. This is the concatenated {user-id}:{appRole-id} separated by a colon. | |
| **if_match** | **string**| ETag | [optional] |

### Return type

void (empty response body)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `userListAppRoleAssignments()`

```php
userListAppRoleAssignments($user_id): \OpenAPI\Client\Model\CollectionOfAppRoleAssignments
```

Get appRoleAssignments from a user

Represents the global roles a user has been granted for an application.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\UserAppRoleAssignmentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user_id = 'user_id_example'; // string | key: id of user

try {
    $result = $apiInstance->userListAppRoleAssignments($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserAppRoleAssignmentApi->userListAppRoleAssignments: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user_id** | **string**| key: id of user | |

### Return type

[**\OpenAPI\Client\Model\CollectionOfAppRoleAssignments**](../Model/CollectionOfAppRoleAssignments.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
