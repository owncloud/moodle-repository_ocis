# # Group

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Read-only. | [optional] [readonly]
**description** | **string** | An optional description for the group. Returned by default. | [optional]
**display_name** | **string** | The display name for the group. This property is required when a group is created and cannot be cleared during updates. Returned by default. Supports $search and $orderBy. | [optional]
**group_types** | **string[]** | Specifies the group types. In MS Graph a group can have multiple types, so this is an array. In libreGraph the possible group types deviate from the MS Graph. The only group type that we currently support is \&quot;ReadOnly\&quot;, which is set for groups that cannot be modified on the current instance. | [optional]
**members** | [**\OpenAPI\Client\Model\User[]**](User.md) | Users and groups that are members of this group. HTTP Methods: GET (supported for all groups), Nullable. Supports $expand. | [optional]
**membersodata_bind** | **string[]** | A list of member references to the members to be added. Up to 20 members can be added with a single request | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
