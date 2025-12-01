# # AppRoleAssignment

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | The unique identifier for the object. 12345678-9abc-def0-1234-56789abcde. The value of the ID property is often, but not exclusively, in the form of a GUID. The value should be treated as an opaque identifier and not based in being a GUID. Null values are not allowed. Read-only. | [optional] [readonly]
**deleted_date_time** | **\DateTime** |  | [optional]
**app_role_id** | **string** | The identifier (id) for the app role which is assigned to the user. Required on create. |
**created_date_time** | **\DateTime** | The time when the app role assignment was created. The Timestamp type represents date and time information using ISO 8601 format and is always in UTC time. For example, midnight UTC on Jan 1, 2014 is 2014-01-01T00:00:00Z. Read-only. | [optional]
**principal_display_name** | **string** | The display name of the user, group, or service principal that was granted the app role assignment. Read-only. | [optional]
**principal_id** | **string** | The unique identifier (id) for the user, security group, or service principal being granted the app role. Security groups with dynamic memberships are supported. Required on create. |
**principal_type** | **string** | The type of the assigned principal. This can either be User, Group, or ServicePrincipal. Read-only. | [optional]
**resource_display_name** | **string** | The display name of the resource app&#39;s service principal to which the assignment is made. | [optional]
**resource_id** | **string** | The unique identifier (id) for the resource service principal for which the assignment is made. Required on create. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
