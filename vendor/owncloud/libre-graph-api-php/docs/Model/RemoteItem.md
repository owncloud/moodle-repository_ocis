# # RemoteItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**created_by** | [**\OpenAPI\Client\Model\IdentitySet**](IdentitySet.md) |  | [optional]
**created_date_time** | **\DateTime** | Date and time of item creation. Read-only. | [optional]
**file** | [**\OpenAPI\Client\Model\OpenGraphFile**](OpenGraphFile.md) |  | [optional]
**file_system_info** | [**\OpenAPI\Client\Model\FileSystemInfo**](FileSystemInfo.md) |  | [optional]
**folder** | [**\OpenAPI\Client\Model\Folder**](Folder.md) |  | [optional]
**drive_alias** | **string** | The drive alias can be used in clients to make the urls user friendly. Example: &#39;personal/einstein&#39;. This will be used to resolve to the correct driveID. | [optional]
**path** | **string** | The relative path of the item in relation to its drive root. | [optional]
**root_id** | **string** | Unique identifier for the drive root of this item. Read-only. | [optional]
**id** | **string** | Unique identifier for the remote item in its drive. Read-only. | [optional]
**image** | [**\OpenAPI\Client\Model\Image**](Image.md) |  | [optional]
**last_modified_by** | [**\OpenAPI\Client\Model\IdentitySet**](IdentitySet.md) |  | [optional]
**last_modified_date_time** | **\DateTime** | Date and time the item was last modified. Read-only. | [optional]
**name** | **string** | Optional. Filename of the remote item. Read-only. | [optional]
**e_tag** | **string** | ETag for the item. Read-only. | [optional] [readonly]
**c_tag** | **string** | An eTag for the content of the item. This eTag is not changed if only the metadata is changed. Note This property is not returned if the item is a folder. Read-only. | [optional] [readonly]
**parent_reference** | [**\OpenAPI\Client\Model\ItemReference**](ItemReference.md) |  | [optional]
**shared** | [**\OpenAPI\Client\Model\Shared**](Shared.md) |  | [optional]
**size** | **int** | Size of the remote item. Read-only. | [optional]
**special_folder** | [**\OpenAPI\Client\Model\SpecialFolder**](SpecialFolder.md) |  | [optional]
**web_dav_url** | **string** | DAV compatible URL for the item. | [optional]
**web_url** | **string** | URL that displays the resource in the browser. Read-only. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
