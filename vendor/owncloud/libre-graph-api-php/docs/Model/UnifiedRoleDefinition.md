# # UnifiedRoleDefinition

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**description** | **string** | The description for the unifiedRoleDefinition. | [optional]
**display_name** | **string** | The display name for the unifiedRoleDefinition. Required. Supports $filter (&#x60;eq&#x60;, &#x60;in&#x60;). | [optional]
**id** | **string** | The unique identifier for the role definition. Key, not nullable, Read-only. Inherited from entity. Supports $filter (&#x60;eq&#x60;, &#x60;in&#x60;). | [optional]
**role_permissions** | [**\OpenAPI\Client\Model\UnifiedRolePermission[]**](UnifiedRolePermission.md) | List of permissions included in the role. | [optional]
**at_libre_graph_weight** | **int** | When presenting a list of roles the weight can be used to order them in a meaningful way. Lower weight gets higher precedence. So content with lower weight will come first. If set, weights should be non-zero, as 0 is interpreted as an unset weight. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
