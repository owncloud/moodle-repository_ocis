# # Drive

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | The unique identifier for this drive. | [optional] [readonly]
**created_by** | [**\OpenAPI\Client\Model\IdentitySet**](IdentitySet.md) |  | [optional]
**created_date_time** | **\DateTime** | Date and time of item creation. Read-only. | [optional] [readonly]
**description** | **string** | Provides a user-visible description of the item. Optional. | [optional]
**e_tag** | **string** | ETag for the item. Read-only. | [optional] [readonly]
**last_modified_by** | [**\OpenAPI\Client\Model\IdentitySet**](IdentitySet.md) |  | [optional]
**last_modified_date_time** | **\DateTime** | Date and time the item was last modified. Read-only. | [optional] [readonly]
**name** | **string** | The name of the item. Read-write. |
**parent_reference** | [**\OpenAPI\Client\Model\ItemReference**](ItemReference.md) |  | [optional]
**web_url** | **string** | URL that displays the resource in the browser. Read-only. | [optional] [readonly]
**drive_type** | **string** | Describes the type of drive represented by this resource. Values are \&quot;personal\&quot; for users home spaces, \&quot;project\&quot;, \&quot;virtual\&quot; or \&quot;share\&quot;. Read-only. | [optional] [readonly]
**drive_alias** | **string** | The drive alias can be used in clients to make the urls user friendly. Example: &#39;personal/einstein&#39;. This will be used to resolve to the correct driveID. | [optional]
**owner** | [**\OpenAPI\Client\Model\IdentitySet**](IdentitySet.md) |  | [optional]
**quota** | [**\OpenAPI\Client\Model\Quota**](Quota.md) |  | [optional]
**items** | [**\OpenAPI\Client\Model\DriveItem[]**](DriveItem.md) | All items contained in the drive. Read-only. Nullable. | [optional] [readonly]
**root** | [**\OpenAPI\Client\Model\DriveItem**](DriveItem.md) |  | [optional]
**special** | [**\OpenAPI\Client\Model\DriveItem[]**](DriveItem.md) | A collection of special drive resources. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
