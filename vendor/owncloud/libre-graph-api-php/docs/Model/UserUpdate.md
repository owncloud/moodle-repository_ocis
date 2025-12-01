# # UserUpdate

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Read-only. | [optional] [readonly]
**account_enabled** | **bool** | Set to \&quot;true\&quot; when the account is enabled. | [optional]
**app_role_assignments** | [**\OpenAPI\Client\Model\AppRoleAssignment[]**](AppRoleAssignment.md) | The apps and app roles which this user has been assigned. | [optional] [readonly]
**display_name** | **string** | The name displayed in the address book for the user. This value is usually the combination of the user&#39;s first name, middle initial, and last name. This property is required when a user is created and it cannot be cleared during updates. Returned by default. Supports $orderby. | [optional]
**drives** | [**\OpenAPI\Client\Model\Drive[]**](Drive.md) | A collection of drives available for this user. Read-only. | [optional] [readonly]
**drive** | [**\OpenAPI\Client\Model\Drive**](Drive.md) |  | [optional]
**identities** | [**\OpenAPI\Client\Model\ObjectIdentity[]**](ObjectIdentity.md) | Identities associated with this account. | [optional]
**mail** | **string** | The SMTP address for the user, for example, &#39;jeff@contoso.onowncloud.com&#39;. Returned by default. | [optional]
**member_of** | [**\OpenAPI\Client\Model\Group[]**](Group.md) | Groups that this user is a member of. HTTP Methods: GET (supported for all groups). Read-only. Nullable. Supports $expand. | [optional] [readonly]
**on_premises_sam_account_name** | **string** | Contains the on-premises SAM account name synchronized from the on-premises directory. | [optional]
**password_profile** | [**\OpenAPI\Client\Model\PasswordProfile**](PasswordProfile.md) |  | [optional]
**surname** | **string** | The user&#39;s surname (family name or last name). Returned by default. | [optional]
**given_name** | **string** | The user&#39;s givenName. Returned by default. | [optional]
**user_type** | **string** | The user&#x60;s type. This can be either \&quot;Member\&quot; for regular user, \&quot;Guest\&quot; for guest users or \&quot;Federated\&quot; for users imported from a federated instance. | [optional] [readonly]
**preferred_language** | **string** | Represents the users language setting, ISO-639-1 Code | [optional]
**sign_in_activity** | [**\OpenAPI\Client\Model\SignInActivity**](SignInActivity.md) |  | [optional]
**external_id** | **string** | A unique identifier assigned to the user by the organization. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
