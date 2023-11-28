# # EducationClass

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Read-only. | [optional] [readonly]
**description** | **string** | An optional description for the group. Returned by default. | [optional]
**display_name** | **string** | The display name for the group. This property is required when a group is created and cannot be cleared during updates. Returned by default. Supports $search and $orderBy. |
**members** | [**\OpenAPI\Client\Model\User[]**](User.md) | Users and groups that are members of this group. HTTP Methods: GET (supported for all groups), Nullable. Supports $expand. | [optional]
**membersodata_bind** | **string[]** | A list of member references to the members to be added. Up to 20 members can be added with a single request | [optional]
**classification** | **string** | Classification of the group, i.e. \&quot;class\&quot; or \&quot;course\&quot; |
**external_id** | **string** | An external unique ID for the class | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
