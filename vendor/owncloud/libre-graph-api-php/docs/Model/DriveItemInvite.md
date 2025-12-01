# # DriveItemInvite

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**recipients** | [**\OpenAPI\Client\Model\DriveRecipient[]**](DriveRecipient.md) | A collection of recipients who will receive access and the sharing invitation. Currently, only internal users or groups are supported. | [optional]
**roles** | **string[]** | Specifies the roles that are to be granted to the recipients of the sharing invitation. | [optional]
**at_libre_graph_permissions_actions** | **string[]** | Specifies the actions that are to be granted to the recipients of the sharing invitation, in effect creating a custom role. | [optional]
**expiration_date_time** | **\DateTime** | Specifies the dateTime after which the permission expires. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
