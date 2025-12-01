# OpenAPI\Client\DrivesRootApi

All URIs are relative to https://ocis.ocis.rolling.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createDriveItem()**](DrivesRootApi.md#createDriveItem) | **POST** /v1beta1/drives/{drive-id}/root/children | Create a drive item |
| [**createLinkSpaceRoot()**](DrivesRootApi.md#createLinkSpaceRoot) | **POST** /v1beta1/drives/{drive-id}/root/createLink | Create a sharing link for the root item of a Drive |
| [**deletePermissionSpaceRoot()**](DrivesRootApi.md#deletePermissionSpaceRoot) | **DELETE** /v1beta1/drives/{drive-id}/root/permissions/{perm-id} | Remove access to a Drive |
| [**getPermissionSpaceRoot()**](DrivesRootApi.md#getPermissionSpaceRoot) | **GET** /v1beta1/drives/{drive-id}/root/permissions/{perm-id} | Get a single sharing permission for the root item of a drive |
| [**getRoot()**](DrivesRootApi.md#getRoot) | **GET** /v1.0/drives/{drive-id}/root | Get root from arbitrary space |
| [**inviteSpaceRoot()**](DrivesRootApi.md#inviteSpaceRoot) | **POST** /v1beta1/drives/{drive-id}/root/invite | Send a sharing invitation |
| [**listPermissionsSpaceRoot()**](DrivesRootApi.md#listPermissionsSpaceRoot) | **GET** /v1beta1/drives/{drive-id}/root/permissions | List the effective permissions on the root item of a drive. |
| [**setPermissionPasswordSpaceRoot()**](DrivesRootApi.md#setPermissionPasswordSpaceRoot) | **POST** /v1beta1/drives/{drive-id}/root/permissions/{perm-id}/setPassword | Set sharing link password for the root item of a drive |
| [**updatePermissionSpaceRoot()**](DrivesRootApi.md#updatePermissionSpaceRoot) | **PATCH** /v1beta1/drives/{drive-id}/root/permissions/{perm-id} | Update sharing permission |


## `createDriveItem()`

```php
createDriveItem($drive_id, $drive_item): \OpenAPI\Client\Model\DriveItem
```

Create a drive item

You can use the root childrens endpoint to mount a remoteItem in the share jail. The `@client.synchronize` property of the `driveItem` in the [sharedWithMe](#/me.drive/ListSharedWithMe) endpoint will change to true.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesRootApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = a0ca6a90-a365-4782-871e-d44447bbc668$a0ca6a90-a365-4782-871e-d44447bbc668; // string | key: id of drive
$drive_item = {"name":"Einsteins project share","remoteItem":{"id":"a-storage-provider-id$a-space-id!a-node-id"}}; // \OpenAPI\Client\Model\DriveItem | In the request body, provide a JSON object with the following parameters. For mounting a share the necessary remoteItem id and permission id can be taken from the [sharedWithMe](#/me.drive/ListSharedWithMe) endpoint.

try {
    $result = $apiInstance->createDriveItem($drive_id, $drive_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesRootApi->createDriveItem: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **drive_item** | [**\OpenAPI\Client\Model\DriveItem**](../Model/DriveItem.md)| In the request body, provide a JSON object with the following parameters. For mounting a share the necessary remoteItem id and permission id can be taken from the [sharedWithMe](#/me.drive/ListSharedWithMe) endpoint. | [optional] |

### Return type

[**\OpenAPI\Client\Model\DriveItem**](../Model/DriveItem.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `createLinkSpaceRoot()`

```php
createLinkSpaceRoot($drive_id, $drive_item_create_link): \OpenAPI\Client\Model\Permission
```

Create a sharing link for the root item of a Drive

You can use the createLink action to share a driveItem via a sharing link.  The response will be a permission object with the link facet containing the created link details.  ## Link types  For now, The following values are allowed for the type parameter.  | Value          | Display name      | Description                                                     | | -------------- | ----------------- | --------------------------------------------------------------- | | view           | View              | Creates a read-only link to the driveItem.                      | | upload         | Upload            | Creates a read-write link to the folder driveItem.              | | edit           | Edit              | Creates a read-write link to the driveItem.                     | | createOnly     | File Drop         | Creates an upload-only link to the folder driveItem.            | | blocksDownload | Secure View       | Creates a read-only link that blocks download to the driveItem. |

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesRootApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$drive_item_create_link = {"type":"view"}; // \OpenAPI\Client\Model\DriveItemCreateLink | In the request body, provide a JSON object with the following parameters.

try {
    $result = $apiInstance->createLinkSpaceRoot($drive_id, $drive_item_create_link);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesRootApi->createLinkSpaceRoot: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **drive_item_create_link** | [**\OpenAPI\Client\Model\DriveItemCreateLink**](../Model/DriveItemCreateLink.md)| In the request body, provide a JSON object with the following parameters. | [optional] |

### Return type

[**\OpenAPI\Client\Model\Permission**](../Model/Permission.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deletePermissionSpaceRoot()`

```php
deletePermissionSpaceRoot($drive_id, $perm_id)
```

Remove access to a Drive

Remove access to the root item of a drive.  Only sharing permissions that are not inherited can be deleted. The `inheritedFrom` property must be `null`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesRootApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$perm_id = 'perm_id_example'; // string | key: id of permission

try {
    $apiInstance->deletePermissionSpaceRoot($drive_id, $perm_id);
} catch (Exception $e) {
    echo 'Exception when calling DrivesRootApi->deletePermissionSpaceRoot: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **perm_id** | **string**| key: id of permission | |

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

## `getPermissionSpaceRoot()`

```php
getPermissionSpaceRoot($drive_id, $perm_id): \OpenAPI\Client\Model\Permission
```

Get a single sharing permission for the root item of a drive

Return the effective sharing permission for a particular permission resource.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesRootApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$perm_id = 'perm_id_example'; // string | key: id of permission

try {
    $result = $apiInstance->getPermissionSpaceRoot($drive_id, $perm_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesRootApi->getPermissionSpaceRoot: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **perm_id** | **string**| key: id of permission | |

### Return type

[**\OpenAPI\Client\Model\Permission**](../Model/Permission.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getRoot()`

```php
getRoot($drive_id): \OpenAPI\Client\Model\DriveItem
```

Get root from arbitrary space

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesRootApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive

try {
    $result = $apiInstance->getRoot($drive_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesRootApi->getRoot: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |

### Return type

[**\OpenAPI\Client\Model\DriveItem**](../Model/DriveItem.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `inviteSpaceRoot()`

```php
inviteSpaceRoot($drive_id, $drive_item_invite): \OpenAPI\Client\Model\CollectionOfPermissions
```

Send a sharing invitation

Sends a sharing invitation for the root of a `drive`. A sharing invitation provides permissions to the recipients and optionally sends them an email with a sharing link.  The response will be a permission object with the grantedToV2 property containing the created grant details.  ## Roles property values For now, roles are only identified by a uuid. There are no hardcoded aliases like `read` or `write` because role actions can be completely customized.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesRootApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$drive_item_invite = {"recipients":[{"@libre.graph.recipient.type":"user","objectId":"4c510ada-c86b-4815-8820-42cdf82c3d51"}],"roles":["b1e2218d-eef8-4d4c-b82d-0f1a1b48f3b5"]}; // \OpenAPI\Client\Model\DriveItemInvite | In the request body, provide a JSON object with the following parameters. To create a custom role submit a list of actions instead of roles.

try {
    $result = $apiInstance->inviteSpaceRoot($drive_id, $drive_item_invite);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesRootApi->inviteSpaceRoot: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **drive_item_invite** | [**\OpenAPI\Client\Model\DriveItemInvite**](../Model/DriveItemInvite.md)| In the request body, provide a JSON object with the following parameters. To create a custom role submit a list of actions instead of roles. | [optional] |

### Return type

[**\OpenAPI\Client\Model\CollectionOfPermissions**](../Model/CollectionOfPermissions.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listPermissionsSpaceRoot()`

```php
listPermissionsSpaceRoot($drive_id, $filter, $select): \OpenAPI\Client\Model\CollectionOfPermissionsWithAllowedValues
```

List the effective permissions on the root item of a drive.

The permissions collection includes potentially sensitive information and may not be available for every caller.  * For the owner of the item, all sharing permissions will be returned. This includes co-owners. * For a non-owner caller, only the sharing permissions that apply to the caller are returned. * Sharing permission properties that contain secrets (e.g. `webUrl`) are only returned for callers that are able to create the sharing permission.  All permission objects have an `id`. A permission representing * a link has the `link` facet filled with details. * a share has the `roles` property set and the `grantedToV2` property filled with the grant recipient details.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesRootApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$filter = @libre.graph.permissions.roles.allowedValues/rolePermissions/any(p:contains(p/condition, '@Subject.UserType=="Federated"')); // string | Filter items by property values. By default all permissions are returned and the avalable sharing roles are limited to normal users. To get a list of sharing roles applicable to federated users use the example $select query and combine it with $filter to omit the list of permissions.
$select = array('select_example'); // string[] | Select properties to be returned. By default all properties are returned. Select the roles property to fetch the available sharing roles without resolving all the permissions. Combine this with the $filter parameter to fetch the actions applicable to federated users.

try {
    $result = $apiInstance->listPermissionsSpaceRoot($drive_id, $filter, $select);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesRootApi->listPermissionsSpaceRoot: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **filter** | **string**| Filter items by property values. By default all permissions are returned and the avalable sharing roles are limited to normal users. To get a list of sharing roles applicable to federated users use the example $select query and combine it with $filter to omit the list of permissions. | [optional] |
| **select** | [**string[]**](../Model/string.md)| Select properties to be returned. By default all properties are returned. Select the roles property to fetch the available sharing roles without resolving all the permissions. Combine this with the $filter parameter to fetch the actions applicable to federated users. | [optional] |

### Return type

[**\OpenAPI\Client\Model\CollectionOfPermissionsWithAllowedValues**](../Model/CollectionOfPermissionsWithAllowedValues.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `setPermissionPasswordSpaceRoot()`

```php
setPermissionPasswordSpaceRoot($drive_id, $perm_id, $sharing_link_password): \OpenAPI\Client\Model\Permission
```

Set sharing link password for the root item of a drive

Set the password of a sharing permission.  Only the `password` property can be modified this way.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesRootApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$perm_id = 'perm_id_example'; // string | key: id of permission
$sharing_link_password = {"password":"TestPassword123!"}; // \OpenAPI\Client\Model\SharingLinkPassword | New password value

try {
    $result = $apiInstance->setPermissionPasswordSpaceRoot($drive_id, $perm_id, $sharing_link_password);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesRootApi->setPermissionPasswordSpaceRoot: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **perm_id** | **string**| key: id of permission | |
| **sharing_link_password** | [**\OpenAPI\Client\Model\SharingLinkPassword**](../Model/SharingLinkPassword.md)| New password value | |

### Return type

[**\OpenAPI\Client\Model\Permission**](../Model/Permission.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updatePermissionSpaceRoot()`

```php
updatePermissionSpaceRoot($drive_id, $perm_id, $permission): \OpenAPI\Client\Model\Permission
```

Update sharing permission

Update the properties of a sharing permission by patching the permission resource.  Only the `roles`, `expirationDateTime` and `password` properties can be modified this way.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure HTTP basic authorization: basicAuth
$config = OpenAPI\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new OpenAPI\Client\Api\DrivesRootApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$drive_id = 'drive_id_example'; // string | key: id of drive
$perm_id = 'perm_id_example'; // string | key: id of permission
$permission = {"link":{"type":"edit"}}; // \OpenAPI\Client\Model\Permission | New property values

try {
    $result = $apiInstance->updatePermissionSpaceRoot($drive_id, $perm_id, $permission);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DrivesRootApi->updatePermissionSpaceRoot: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **drive_id** | **string**| key: id of drive | |
| **perm_id** | **string**| key: id of permission | |
| **permission** | [**\OpenAPI\Client\Model\Permission**](../Model/Permission.md)| New property values | |

### Return type

[**\OpenAPI\Client\Model\Permission**](../Model/Permission.md)

### Authorization

[openId](../../README.md#openId), [basicAuth](../../README.md#basicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
