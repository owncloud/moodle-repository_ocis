# OpenAPI\Client\GroupApi

All URIs are relative to https://ocis.ocis-traefik.latest.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**addMember()**](GroupApi.md#addMember) | **POST** /v1.0/groups/{group-id}/members/$ref | Add a member to a group |
| [**deleteGroup()**](GroupApi.md#deleteGroup) | **DELETE** /v1.0/groups/{group-id} | Delete entity from groups |
| [**deleteMember()**](GroupApi.md#deleteMember) | **DELETE** /v1.0/groups/{group-id}/members/{directory-object-id}/$ref | Delete member from a group |
| [**getGroup()**](GroupApi.md#getGroup) | **GET** /v1.0/groups/{group-id} | Get entity from groups by key |
| [**listMembers()**](GroupApi.md#listMembers) | **GET** /v1.0/groups/{group-id}/members | Get a list of the group&#39;s direct members |
| [**updateGroup()**](GroupApi.md#updateGroup) | **PATCH** /v1.0/groups/{group-id} | Update entity in groups |


## `addMember()`

```php
addMember($group_id, $member_reference)
```

Add a member to a group

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\GroupApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$group_id = 'group_id_example'; // string | key: id of group
$member_reference = new \OpenAPI\Client\Model\MemberReference(); // \OpenAPI\Client\Model\MemberReference | Object to be added as member

try {
    $apiInstance->addMember($group_id, $member_reference);
} catch (Exception $e) {
    echo 'Exception when calling GroupApi->addMember: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **group_id** | **string**| key: id of group | |
| **member_reference** | [**\OpenAPI\Client\Model\MemberReference**](../Model/MemberReference.md)| Object to be added as member | |

### Return type

void (empty response body)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteGroup()`

```php
deleteGroup($group_id, $if_match)
```

Delete entity from groups

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\GroupApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$group_id = 'group_id_example'; // string | key: id of group
$if_match = 'if_match_example'; // string | ETag

try {
    $apiInstance->deleteGroup($group_id, $if_match);
} catch (Exception $e) {
    echo 'Exception when calling GroupApi->deleteGroup: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **group_id** | **string**| key: id of group | |
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

## `deleteMember()`

```php
deleteMember($group_id, $directory_object_id, $if_match)
```

Delete member from a group

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\GroupApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$group_id = 'group_id_example'; // string | key: id of group
$directory_object_id = 'directory_object_id_example'; // string | key: id of group member to remove
$if_match = 'if_match_example'; // string | ETag

try {
    $apiInstance->deleteMember($group_id, $directory_object_id, $if_match);
} catch (Exception $e) {
    echo 'Exception when calling GroupApi->deleteMember: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **group_id** | **string**| key: id of group | |
| **directory_object_id** | **string**| key: id of group member to remove | |
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

## `getGroup()`

```php
getGroup($group_id, $select, $expand): \OpenAPI\Client\Model\Group
```

Get entity from groups by key

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\GroupApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$group_id = 'group_id_example'; // string | key: id or name of group
$select = array('select_example'); // string[] | Select properties to be returned
$expand = array('expand_example'); // string[] | Expand related entities

try {
    $result = $apiInstance->getGroup($group_id, $select, $expand);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GroupApi->getGroup: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **group_id** | **string**| key: id or name of group | |
| **select** | [**string[]**](../Model/string.md)| Select properties to be returned | [optional] |
| **expand** | [**string[]**](../Model/string.md)| Expand related entities | [optional] |

### Return type

[**\OpenAPI\Client\Model\Group**](../Model/Group.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listMembers()`

```php
listMembers($group_id): \OpenAPI\Client\Model\CollectionOfUsers
```

Get a list of the group's direct members

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\GroupApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$group_id = 86948e45-96a6-43df-b83d-46e92afd30de; // string | key: id or name of group

try {
    $result = $apiInstance->listMembers($group_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling GroupApi->listMembers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **group_id** | **string**| key: id or name of group | |

### Return type

[**\OpenAPI\Client\Model\CollectionOfUsers**](../Model/CollectionOfUsers.md)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateGroup()`

```php
updateGroup($group_id, $group)
```

Update entity in groups

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\GroupApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$group_id = 'group_id_example'; // string | key: id of group
$group = new \OpenAPI\Client\Model\Group(); // \OpenAPI\Client\Model\Group | New property values

try {
    $apiInstance->updateGroup($group_id, $group);
} catch (Exception $e) {
    echo 'Exception when calling GroupApi->updateGroup: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **group_id** | **string**| key: id of group | |
| **group** | [**\OpenAPI\Client\Model\Group**](../Model/Group.md)| New property values | |

### Return type

void (empty response body)

### Authorization

[openId](../../README.md#openId)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
