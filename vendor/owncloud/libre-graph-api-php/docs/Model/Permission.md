# # Permission

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | The unique identifier of the permission among all permissions on the item. Read-only. | [optional] [readonly]
**has_password** | **bool** | Indicates whether the password is set for this permission. This property only appears in the response. Optional. Read-only. | [optional] [readonly]
**expiration_date_time** | **\DateTime** | An optional expiration date which limits the permission in time. | [optional]
**granted_to_v2** | [**\OpenAPI\Client\Model\SharePointIdentitySet**](SharePointIdentitySet.md) |  | [optional]
**link** | [**\OpenAPI\Client\Model\SharingLink**](SharingLink.md) |  | [optional]
**roles** | **string[]** |  | [optional]
**granted_to_identities** | [**\OpenAPI\Client\Model\IdentitySet[]**](IdentitySet.md) | For link type permissions, the details of the identity to whom permission was granted. This could be used to grant access to a an external user that can be identified by email, aka guest accounts. | [optional]
**at_libre_graph_permissions_actions** | **string[]** | Use this to create a permission with custom actions. | [optional]
**at_ui_hidden** | **bool** | Properties or facets (see UI.Facet) annotated with this term will not be rendered if the annotation evaluates to true. Users can set this to hide permissons. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
