# # AppRole

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**allowed_member_types** | **string[]** | Specifies whether this app role can be assigned to users and groups (by setting to [&#39;User&#39;]), to other application&#39;s (by setting to [&#39;Application&#39;], or both (by setting to [&#39;User&#39;, &#39;Application&#39;]). App roles supporting assignment to other applications&#39; service principals are also known as application permissions. The &#39;Application&#39; value is only supported for app roles defined on application entities. | [optional]
**description** | **string** | The description for the app role. This is displayed when the app role is being assigned and, if the app role functions as an application permission, during  consent experiences. | [optional]
**display_name** | **string** | Display name for the permission that appears in the app role assignment and consent experiences. | [optional]
**id** | **string** | Unique role identifier inside the appRoles collection. When creating a new app role, a new GUID identifier must be provided. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
