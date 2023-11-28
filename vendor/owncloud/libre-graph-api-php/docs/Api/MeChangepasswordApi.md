# OpenAPI\Client\MeChangepasswordApi

All URIs are relative to https://ocis.ocis-traefik.latest.owncloud.works/graph, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**changeOwnPassword()**](MeChangepasswordApi.md#changeOwnPassword) | **POST** /v1.0/me/changePassword | Chanage your own password |


## `changeOwnPassword()`

```php
changeOwnPassword($password_change)
```

Chanage your own password

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');




$apiInstance = new OpenAPI\Client\Api\MeChangepasswordApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$password_change = new \OpenAPI\Client\Model\PasswordChange(); // \OpenAPI\Client\Model\PasswordChange | Password change request

try {
    $apiInstance->changeOwnPassword($password_change);
} catch (Exception $e) {
    echo 'Exception when calling MeChangepasswordApi->changeOwnPassword: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **password_change** | [**\OpenAPI\Client\Model\PasswordChange**](../Model/PasswordChange.md)| Password change request | |

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
