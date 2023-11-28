# OpenAPI\Client\DrivesPermissionsApi

All URIs are relative to https://ocis.ocis-traefik.latest.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createLink()**](DrivesPermissionsApi.md#createLink) | **POST** /v1beta1/drives/{drive-id}/items/{item-id}/createLink | Create a sharing link for a DriveItem |
| [**deletePermission()**](DrivesPermissionsApi.md#deletePermission) | **DELETE** /v1beta1/drives/{drive-id}/items/{item-id}/permissions/{perm-id} | Remove access to a DriveItem |
| [**getPermission()**](DrivesPermissionsApi.md#getPermission) | **GET** /v1beta1/drives/{drive-id}/items/{item-id}/permissions/{perm-id} | Get sharing permission for a file or folder |
| [**invite()**](DrivesPermissionsApi.md#invite) | **POST** /v1beta1/drives/{drive-id}/items/{item-id}/invite | Send a sharing invitation |
| [**listPermissions()**](DrivesPermissionsApi.md#listPermissions) | **GET** /v1beta1/drives/{drive-id}/items/{item-id}/permissions | List the effective sharing permissions on a driveItem. |
| [**setPermissionPassword()**](DrivesPermissionsApi.md#setPermissionPassword) | **POST** /v1beta1/drives/{drive-id}/items/{item-id}/permissions/{perm-id}/setPassword | Set sharing link password |
| [**updatePermission()**](DrivesPermissionsApi.md#updatePermission) | **PATCH** /v1beta1/drives/{drive-id}/items/{item-id}/permissions/{perm-id} | Update sharing permission |


## `createLink()`

```php
createLink($drive_id, $item_id, $drive_item_create_link): \OpenAPI\Client\Model\Permission
```

Create a sharing link for a DriveItem

You can use the createLink action to share a driveItem via a sharing link.  The response will be a permission object with the link facet containing the created link details.  ## Link types  For now, The following values are allowed for the type parameter.  | Value          | Display name      | Description                                                     | | -------------- | ----------------- | --------------------------------------------------------------- | | view           | View              | Creates a read-only link to the driveItem.                      | | upload         | Upload            | Creates a read-write link to the folder driveItem.              | | edit           | Edit              | Creates a read-write link to the driveItem.                     | | createOnly     | File Drop         | Creates an upload-only link to the folder driveItem.            | | blocksDownload | Secure View       | Creates a read-only link that blocks download to the driveItem. |

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\DrivesPermissionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$item_id = 'item_id_example'; // string | key: id of item
$drive_item_create_link = {"type":"view"}; // \OpenAPI\Client\Model\DriveItemCreateLink | In the request body, provide a JSON object with the following parameters.

try {
    $result = $apiInstance->createLink($drive_id, $item_id, $drive_item_create_link);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesPermissionsApi->createLink: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **item_id** | **string**| key: id of item | |
| **drive_item_create_link** | [**\OpenAPI\Client\Model\DriveItemCreateLink**](../Model/DriveItemCreateLink.md)| In the request body, provide a JSON object with the following parameters. | [optional] |

### Return type

[**\OpenAPI\Client\Model\Permission**](../Model/Permission.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deletePermission()`

```php
deletePermission($drive_id, $item_id, $perm_id)
```

Remove access to a DriveItem

Remove access to a DriveItem.  Only sharing permissions that are not inherited can be deleted. The `inheritedFrom` property must be `null`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\DrivesPermissionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$item_id = 'item_id_example'; // string | key: id of item
$perm_id = 'perm_id_example'; // string | key: id of permission

try {
    $apiInstance->deletePermission($drive_id, $item_id, $perm_id);
} catch (Exception $e) {
    echo 'Exception when calling DrivesPermissionsApi->deletePermission: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **item_id** | **string**| key: id of item | |
| **perm_id** | **string**| key: id of permission | |

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

## `getPermission()`

```php
getPermission($drive_id, $item_id, $perm_id): \OpenAPI\Client\Model\Permission
```

Get sharing permission for a file or folder

Return the effective sharing permission for a particular permission resource.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\DrivesPermissionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$item_id = 'item_id_example'; // string | key: id of item
$perm_id = 'perm_id_example'; // string | key: id of permission

try {
    $result = $apiInstance->getPermission($drive_id, $item_id, $perm_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesPermissionsApi->getPermission: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **item_id** | **string**| key: id of item | |
| **perm_id** | **string**| key: id of permission | |

### Return type

[**\OpenAPI\Client\Model\Permission**](../Model/Permission.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `invite()`

```php
invite($drive_id, $item_id, $drive_item_invite): \OpenAPI\Client\Model\CollectionOfPermissions
```

Send a sharing invitation

Sends a sharing invitation for a `driveItem`. A sharing invitation provides permissions to the recipients and optionally sends them an email with a sharing link.  The response will be a permission object with the grantedToV2 property containing the created grant details.  ## Roles property values For now, roles are only identified by a uuid. There are no hardcoded aliases like `read` or `write` because role actions can be completely customized.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\DrivesPermissionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$item_id = 'item_id_example'; // string | key: id of item
$drive_item_invite = {"recipients":[{"objectId":"4c510ada-c86b-4815-8820-42cdf82c3d51"}],"roles":["7ccc2a61-9615-4063-a80a-eb7cd8e59d8"]}; // \OpenAPI\Client\Model\DriveItemInvite | In the request body, provide a JSON object with the following parameters. To create a custom role submit a list of actions instead of roles.

try {
    $result = $apiInstance->invite($drive_id, $item_id, $drive_item_invite);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesPermissionsApi->invite: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **item_id** | **string**| key: id of item | |
| **drive_item_invite** | [**\OpenAPI\Client\Model\DriveItemInvite**](../Model/DriveItemInvite.md)| In the request body, provide a JSON object with the following parameters. To create a custom role submit a list of actions instead of roles. | [optional] |

### Return type

[**\OpenAPI\Client\Model\CollectionOfPermissions**](../Model/CollectionOfPermissions.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listPermissions()`

```php
listPermissions($drive_id, $item_id): \OpenAPI\Client\Model\CollectionOfPermissionsWithAllowedValues
```

List the effective sharing permissions on a driveItem.

The permissions collection includes potentially sensitive information and may not be available for every caller.  * For the owner of the item, all sharing permissions will be returned. This includes co-owners. * For a non-owner caller, only the sharing permissions that apply to the caller are returned. * Sharing permission properties that contain secrets (e.g. `webUrl`) are only returned for callers that are able to create the sharing permission.  All permission objects have an `id`. A permission representing * a link has the `link` facet filled with details.  * a share has the `roles` property set and the `grantedToV2` property filled with the grant recipient details.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\DrivesPermissionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$item_id = 'item_id_example'; // string | key: id of item

try {
    $result = $apiInstance->listPermissions($drive_id, $item_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesPermissionsApi->listPermissions: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **item_id** | **string**| key: id of item | |

### Return type

[**\OpenAPI\Client\Model\CollectionOfPermissionsWithAllowedValues**](../Model/CollectionOfPermissionsWithAllowedValues.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `setPermissionPassword()`

```php
setPermissionPassword($drive_id, $item_id, $perm_id, $sharing_link_password): \OpenAPI\Client\Model\Permission
```

Set sharing link password

Set the password of a sharing permission.  Only the `password` property can be modified this way.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\DrivesPermissionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$item_id = 'item_id_example'; // string | key: id of item
$perm_id = 'perm_id_example'; // string | key: id of permission
$sharing_link_password = {"password":"TestPassword123!"}; // \OpenAPI\Client\Model\SharingLinkPassword | New password value

try {
    $result = $apiInstance->setPermissionPassword($drive_id, $item_id, $perm_id, $sharing_link_password);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesPermissionsApi->setPermissionPassword: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **item_id** | **string**| key: id of item | |
| **perm_id** | **string**| key: id of permission | |
| **sharing_link_password** | [**\OpenAPI\Client\Model\SharingLinkPassword**](../Model/SharingLinkPassword.md)| New password value | |

### Return type

[**\OpenAPI\Client\Model\Permission**](../Model/Permission.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updatePermission()`

```php
updatePermission($drive_id, $item_id, $perm_id, $permission): \OpenAPI\Client\Model\Permission
```

Update sharing permission

Update the properties of a sharing permission by patching the permission resource.  Only the `roles`, `expirationDateTime` and `password` properties can be modified this way.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\DrivesPermissionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$item_id = 'item_id_example'; // string | key: id of item
$perm_id = 'perm_id_example'; // string | key: id of permission
$permission = {"roles":["7ccc2a61-9615-4063-a80a-eb7cd8e59d8"]}; // \OpenAPI\Client\Model\Permission | New property values

try {
    $result = $apiInstance->updatePermission($drive_id, $item_id, $perm_id, $permission);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesPermissionsApi->updatePermission: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **item_id** | **string**| key: id of item | |
| **perm_id** | **string**| key: id of permission | |
| **permission** | [**\OpenAPI\Client\Model\Permission**](../Model/Permission.md)| New property values | |

### Return type

[**\OpenAPI\Client\Model\Permission**](../Model/Permission.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
