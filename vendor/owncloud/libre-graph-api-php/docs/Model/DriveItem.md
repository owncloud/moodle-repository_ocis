# # DriveItem

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Read-only. | [optional] [readonly]
**created_by** | [**\OpenAPI\Client\Model\IdentitySet**](IdentitySet.md) |  | [optional]
**created_date_time** | **\DateTime** | Date and time of item creation. Read-only. | [optional] [readonly]
**description** | **string** | Provides a user-visible description of the item. Optional. | [optional]
**e_tag** | **string** | ETag for the item. Read-only. | [optional] [readonly]
**last_modified_by** | [**\OpenAPI\Client\Model\IdentitySet**](IdentitySet.md) |  | [optional]
**last_modified_date_time** | **\DateTime** | Date and time the item was last modified. Read-only. | [optional] [readonly]
**name** | **string** | The name of the item. Read-write. | [optional]
**parent_reference** | [**\OpenAPI\Client\Model\ItemReference**](ItemReference.md) |  | [optional]
**web_url** | **string** | URL that displays the resource in the browser. Read-only. | [optional] [readonly]
**content** | **string** | The content stream, if the item represents a file. | [optional]
**c_tag** | **string** | An eTag for the content of the item. This eTag is not changed if only the metadata is changed. Note This property is not returned if the item is a folder. Read-only. | [optional] [readonly]
**deleted** | [**\OpenAPI\Client\Model\Deleted**](Deleted.md) |  | [optional]
**file** | [**\OpenAPI\Client\Model\OpenGraphFile**](OpenGraphFile.md) |  | [optional]
**file_system_info** | [**\OpenAPI\Client\Model\FileSystemInfo**](FileSystemInfo.md) |  | [optional]
**folder** | [**\OpenAPI\Client\Model\Folder**](Folder.md) |  | [optional]
**image** | [**\OpenAPI\Client\Model\Image**](Image.md) |  | [optional]
**photo** | [**\OpenAPI\Client\Model\Photo**](Photo.md) |  | [optional]
**location** | [**\OpenAPI\Client\Model\GeoCoordinates**](GeoCoordinates.md) |  | [optional]
**root** | **object** | If this property is non-null, it indicates that the driveItem is the top-most driveItem in the drive. | [optional]
**trash** | [**\OpenAPI\Client\Model\Trash**](Trash.md) |  | [optional]
**special_folder** | [**\OpenAPI\Client\Model\SpecialFolder**](SpecialFolder.md) |  | [optional]
**remote_item** | [**\OpenAPI\Client\Model\RemoteItem**](RemoteItem.md) |  | [optional]
**size** | **int** | Size of the item in bytes. Read-only. | [optional] [readonly]
**web_dav_url** | **string** | WebDAV compatible URL for the item. Read-only. | [optional] [readonly]
**children** | [**\OpenAPI\Client\Model\DriveItem[]**](DriveItem.md) | Collection containing Item objects for the immediate children of Item. Only items representing folders have children. Read-only. Nullable. | [optional] [readonly]
**permissions** | [**\OpenAPI\Client\Model\Permission[]**](Permission.md) | The set of permissions for the item. Read-only. Nullable. | [optional] [readonly]
**audio** | [**\OpenAPI\Client\Model\Audio**](Audio.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
