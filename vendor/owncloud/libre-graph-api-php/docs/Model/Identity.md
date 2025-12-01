# # Identity

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**display_name** | **string** | The identity&#39;s display name. Note that this may not always be available or up to date. For example, if a user changes their display name, the API may show the new value in a future response, but the items associated with the user won&#39;t show up as having changed when using delta. |
**id** | **string** | Unique identifier for the identity. | [optional]
**at_libre_graph_user_type** | **string** | The type of the identity. This can be either \&quot;Member\&quot; for regular user, \&quot;Guest\&quot; for guest users or \&quot;Federated\&quot; for users imported from a federated instance. Can be used by clients to indicate the type of user. For more details, clients should look up and cache the user at the /users endpoint. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
