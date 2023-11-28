# libregraph

Libre Graph is a free API for cloud collaboration inspired by the MS Graph API.


## Installation & Usage

### Requirements

PHP 8.1 and later.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/owncloud/libre-graph-api-php.git"
    }
  ],
  "require": {
    "owncloud/libre-graph-api-php": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/libregraph/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');





$apiInstance = new OpenAPI\Client\Api\ApplicationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$application_id = 'application_id_example'; // string | key: id of application

try {
    $result = $apiInstance->getApplication($application_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ApplicationsApi->getApplication: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *https://ocis.ocis-traefik.latest.owncloud.works/graph*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*ApplicationsApi* | [**getApplication**](docs/Api/ApplicationsApi.md#getapplication) | **GET** /v1.0/applications/{application-id} | Get application by id
*ApplicationsApi* | [**listApplications**](docs/Api/ApplicationsApi.md#listapplications) | **GET** /v1.0/applications | Get all applications
*DrivesApi* | [**createDrive**](docs/Api/DrivesApi.md#createdrive) | **POST** /v1.0/drives | Create a new drive of a specific type
*DrivesApi* | [**deleteDrive**](docs/Api/DrivesApi.md#deletedrive) | **DELETE** /v1.0/drives/{drive-id} | Delete a specific space
*DrivesApi* | [**getDrive**](docs/Api/DrivesApi.md#getdrive) | **GET** /v1.0/drives/{drive-id} | Get drive by id
*DrivesApi* | [**updateDrive**](docs/Api/DrivesApi.md#updatedrive) | **PATCH** /v1.0/drives/{drive-id} | Update the drive
*DrivesGetDrivesApi* | [**listAllDrives**](docs/Api/DrivesGetDrivesApi.md#listalldrives) | **GET** /v1.0/drives | Get all available drives
*DrivesPermissionsApi* | [**createLink**](docs/Api/DrivesPermissionsApi.md#createlink) | **POST** /v1beta1/drives/{drive-id}/items/{item-id}/createLink | Create a sharing link for a DriveItem
*DrivesPermissionsApi* | [**deletePermission**](docs/Api/DrivesPermissionsApi.md#deletepermission) | **DELETE** /v1beta1/drives/{drive-id}/items/{item-id}/permissions/{perm-id} | Remove access to a DriveItem
*DrivesPermissionsApi* | [**getPermission**](docs/Api/DrivesPermissionsApi.md#getpermission) | **GET** /v1beta1/drives/{drive-id}/items/{item-id}/permissions/{perm-id} | Get sharing permission for a file or folder
*DrivesPermissionsApi* | [**invite**](docs/Api/DrivesPermissionsApi.md#invite) | **POST** /v1beta1/drives/{drive-id}/items/{item-id}/invite | Send a sharing invitation
*DrivesPermissionsApi* | [**listPermissions**](docs/Api/DrivesPermissionsApi.md#listpermissions) | **GET** /v1beta1/drives/{drive-id}/items/{item-id}/permissions | List the effective sharing permissions on a driveItem.
*DrivesPermissionsApi* | [**setPermissionPassword**](docs/Api/DrivesPermissionsApi.md#setpermissionpassword) | **POST** /v1beta1/drives/{drive-id}/items/{item-id}/permissions/{perm-id}/setPassword | Set sharing link password
*DrivesPermissionsApi* | [**updatePermission**](docs/Api/DrivesPermissionsApi.md#updatepermission) | **PATCH** /v1beta1/drives/{drive-id}/items/{item-id}/permissions/{perm-id} | Update sharing permission
*DrivesRootApi* | [**getRoot**](docs/Api/DrivesRootApi.md#getroot) | **GET** /v1.0/drives/{drive-id}/root | Get root from arbitrary space
*EducationClassApi* | [**addUserToClass**](docs/Api/EducationClassApi.md#addusertoclass) | **POST** /v1.0/education/classes/{class-id}/members/$ref | Assign a user to a class
*EducationClassApi* | [**createClass**](docs/Api/EducationClassApi.md#createclass) | **POST** /v1.0/education/classes | Add new education class
*EducationClassApi* | [**deleteClass**](docs/Api/EducationClassApi.md#deleteclass) | **DELETE** /v1.0/education/classes/{class-id} | Delete education class
*EducationClassApi* | [**deleteUserFromClass**](docs/Api/EducationClassApi.md#deleteuserfromclass) | **DELETE** /v1.0/education/classes/{class-id}/members/{user-id}/$ref | Unassign user from a class
*EducationClassApi* | [**getClass**](docs/Api/EducationClassApi.md#getclass) | **GET** /v1.0/education/classes/{class-id} | Get class by key
*EducationClassApi* | [**listClassMembers**](docs/Api/EducationClassApi.md#listclassmembers) | **GET** /v1.0/education/classes/{class-id}/members | Get the educationClass resources owned by an educationSchool
*EducationClassApi* | [**listClasses**](docs/Api/EducationClassApi.md#listclasses) | **GET** /v1.0/education/classes | list education classes
*EducationClassApi* | [**updateClass**](docs/Api/EducationClassApi.md#updateclass) | **PATCH** /v1.0/education/classes/{class-id} | Update properties of a education class
*EducationClassTeachersApi* | [**addTeacherToClass**](docs/Api/EducationClassTeachersApi.md#addteachertoclass) | **POST** /v1.0/education/classes/{class-id}/teachers/$ref | Assign a teacher to a class
*EducationClassTeachersApi* | [**deleteTeacherFromClass**](docs/Api/EducationClassTeachersApi.md#deleteteacherfromclass) | **DELETE** /v1.0/education/classes/{class-id}/teachers/{user-id}/$ref | Unassign user as teacher of a class
*EducationClassTeachersApi* | [**getTeachers**](docs/Api/EducationClassTeachersApi.md#getteachers) | **GET** /v1.0/education/classes/{class-id}/teachers | Get the teachers for a class
*EducationSchoolApi* | [**addClassToSchool**](docs/Api/EducationSchoolApi.md#addclasstoschool) | **POST** /v1.0/education/schools/{school-id}/classes/$ref | Assign a class to a school
*EducationSchoolApi* | [**addUserToSchool**](docs/Api/EducationSchoolApi.md#addusertoschool) | **POST** /v1.0/education/schools/{school-id}/users/$ref | Assign a user to a school
*EducationSchoolApi* | [**createSchool**](docs/Api/EducationSchoolApi.md#createschool) | **POST** /v1.0/education/schools | Add new school
*EducationSchoolApi* | [**deleteClassFromSchool**](docs/Api/EducationSchoolApi.md#deleteclassfromschool) | **DELETE** /v1.0/education/schools/{school-id}/classes/{class-id}/$ref | Unassign class from a school
*EducationSchoolApi* | [**deleteSchool**](docs/Api/EducationSchoolApi.md#deleteschool) | **DELETE** /v1.0/education/schools/{school-id} | Delete school
*EducationSchoolApi* | [**deleteUserFromSchool**](docs/Api/EducationSchoolApi.md#deleteuserfromschool) | **DELETE** /v1.0/education/schools/{school-id}/users/{user-id}/$ref | Unassign user from a school
*EducationSchoolApi* | [**getSchool**](docs/Api/EducationSchoolApi.md#getschool) | **GET** /v1.0/education/schools/{school-id} | Get the properties of a specific school
*EducationSchoolApi* | [**listSchoolClasses**](docs/Api/EducationSchoolApi.md#listschoolclasses) | **GET** /v1.0/education/schools/{school-id}/classes | Get the educationClass resources owned by an educationSchool
*EducationSchoolApi* | [**listSchoolUsers**](docs/Api/EducationSchoolApi.md#listschoolusers) | **GET** /v1.0/education/schools/{school-id}/users | Get the educationUser resources associated with an educationSchool
*EducationSchoolApi* | [**listSchools**](docs/Api/EducationSchoolApi.md#listschools) | **GET** /v1.0/education/schools | Get a list of schools and their properties
*EducationSchoolApi* | [**updateSchool**](docs/Api/EducationSchoolApi.md#updateschool) | **PATCH** /v1.0/education/schools/{school-id} | Update properties of a school
*EducationUserApi* | [**createEducationUser**](docs/Api/EducationUserApi.md#createeducationuser) | **POST** /v1.0/education/users | Add new education user
*EducationUserApi* | [**deleteEducationUser**](docs/Api/EducationUserApi.md#deleteeducationuser) | **DELETE** /v1.0/education/users/{user-id} | Delete educationUser
*EducationUserApi* | [**getEducationUser**](docs/Api/EducationUserApi.md#geteducationuser) | **GET** /v1.0/education/users/{user-id} | Get properties of educationUser
*EducationUserApi* | [**listEducationUsers**](docs/Api/EducationUserApi.md#listeducationusers) | **GET** /v1.0/education/users | Get entities from education users
*EducationUserApi* | [**updateEducationUser**](docs/Api/EducationUserApi.md#updateeducationuser) | **PATCH** /v1.0/education/users/{user-id} | Update properties of educationUser
*GroupApi* | [**addMember**](docs/Api/GroupApi.md#addmember) | **POST** /v1.0/groups/{group-id}/members/$ref | Add a member to a group
*GroupApi* | [**deleteGroup**](docs/Api/GroupApi.md#deletegroup) | **DELETE** /v1.0/groups/{group-id} | Delete entity from groups
*GroupApi* | [**deleteMember**](docs/Api/GroupApi.md#deletemember) | **DELETE** /v1.0/groups/{group-id}/members/{directory-object-id}/$ref | Delete member from a group
*GroupApi* | [**getGroup**](docs/Api/GroupApi.md#getgroup) | **GET** /v1.0/groups/{group-id} | Get entity from groups by key
*GroupApi* | [**listMembers**](docs/Api/GroupApi.md#listmembers) | **GET** /v1.0/groups/{group-id}/members | Get a list of the group&#39;s direct members
*GroupApi* | [**updateGroup**](docs/Api/GroupApi.md#updategroup) | **PATCH** /v1.0/groups/{group-id} | Update entity in groups
*GroupsApi* | [**createGroup**](docs/Api/GroupsApi.md#creategroup) | **POST** /v1.0/groups | Add new entity to groups
*GroupsApi* | [**listGroups**](docs/Api/GroupsApi.md#listgroups) | **GET** /v1.0/groups | Get entities from groups
*MeChangepasswordApi* | [**changeOwnPassword**](docs/Api/MeChangepasswordApi.md#changeownpassword) | **POST** /v1.0/me/changePassword | Chanage your own password
*MeDriveApi* | [**getHome**](docs/Api/MeDriveApi.md#gethome) | **GET** /v1.0/me/drive | Get personal space for user
*MeDriveApi* | [**listSharedByMe**](docs/Api/MeDriveApi.md#listsharedbyme) | **GET** /v1beta1/me/drive/sharedByMe | Get a list of driveItem objects shared by the current user.
*MeDriveApi* | [**listSharedWithMe**](docs/Api/MeDriveApi.md#listsharedwithme) | **GET** /v1beta1/me/drive/sharedWithMe | Get a list of driveItem objects shared with the owner of a drive.
*MeDriveRootApi* | [**homeGetRoot**](docs/Api/MeDriveRootApi.md#homegetroot) | **GET** /v1.0/me/drive/root | Get root from personal space
*MeDriveRootChildrenApi* | [**homeGetChildren**](docs/Api/MeDriveRootChildrenApi.md#homegetchildren) | **GET** /v1.0/me/drive/root/children | Get children from drive
*MeDrivesApi* | [**listMyDrives**](docs/Api/MeDrivesApi.md#listmydrives) | **GET** /v1.0/me/drives | Get all drives where the current user is a regular member of
*MeUserApi* | [**getOwnUser**](docs/Api/MeUserApi.md#getownuser) | **GET** /v1.0/me | Get current user
*MeUserApi* | [**updateOwnUser**](docs/Api/MeUserApi.md#updateownuser) | **PATCH** /v1.0/me | Update the current user
*RoleManagementApi* | [**getPermissionRoleDefinition**](docs/Api/RoleManagementApi.md#getpermissionroledefinition) | **GET** /v1beta1/roleManagement/permissions/roleDefinitions/{role-id} | Get unifiedRoleDefinition
*RoleManagementApi* | [**listPermissionRoleDefinitions**](docs/Api/RoleManagementApi.md#listpermissionroledefinitions) | **GET** /v1beta1/roleManagement/permissions/roleDefinitions | List roleDefinitions
*TagsApi* | [**assignTags**](docs/Api/TagsApi.md#assigntags) | **PUT** /v1.0/extensions/org.libregraph/tags | Assign tags to a resource
*TagsApi* | [**getTags**](docs/Api/TagsApi.md#gettags) | **GET** /v1.0/extensions/org.libregraph/tags | Get all known tags
*TagsApi* | [**unassignTags**](docs/Api/TagsApi.md#unassigntags) | **DELETE** /v1.0/extensions/org.libregraph/tags | Unassign tags from a resource
*UserApi* | [**deleteUser**](docs/Api/UserApi.md#deleteuser) | **DELETE** /v1.0/users/{user-id} | Delete entity from users
*UserApi* | [**exportPersonalData**](docs/Api/UserApi.md#exportpersonaldata) | **POST** /v1.0/users/{user-id}/exportPersonalData | export personal data of a user
*UserApi* | [**getUser**](docs/Api/UserApi.md#getuser) | **GET** /v1.0/users/{user-id} | Get entity from users by key
*UserApi* | [**updateUser**](docs/Api/UserApi.md#updateuser) | **PATCH** /v1.0/users/{user-id} | Update entity in users
*UserAppRoleAssignmentApi* | [**userCreateAppRoleAssignments**](docs/Api/UserAppRoleAssignmentApi.md#usercreateapproleassignments) | **POST** /v1.0/users/{user-id}/appRoleAssignments | Grant an appRoleAssignment to a user
*UserAppRoleAssignmentApi* | [**userDeleteAppRoleAssignments**](docs/Api/UserAppRoleAssignmentApi.md#userdeleteapproleassignments) | **DELETE** /v1.0/users/{user-id}/appRoleAssignments/{appRoleAssignment-id} | Delete the appRoleAssignment from a user
*UserAppRoleAssignmentApi* | [**userListAppRoleAssignments**](docs/Api/UserAppRoleAssignmentApi.md#userlistapproleassignments) | **GET** /v1.0/users/{user-id}/appRoleAssignments | Get appRoleAssignments from a user
*UsersApi* | [**createUser**](docs/Api/UsersApi.md#createuser) | **POST** /v1.0/users | Add new entity to users
*UsersApi* | [**listUsers**](docs/Api/UsersApi.md#listusers) | **GET** /v1.0/users | Get entities from users

## Models

- [AppRole](docs/Model/AppRole.md)
- [AppRoleAssignment](docs/Model/AppRoleAssignment.md)
- [Application](docs/Model/Application.md)
- [Audio](docs/Model/Audio.md)
- [ClassMemberReference](docs/Model/ClassMemberReference.md)
- [ClassReference](docs/Model/ClassReference.md)
- [ClassTeacherReference](docs/Model/ClassTeacherReference.md)
- [CollectionOfAppRoleAssignments](docs/Model/CollectionOfAppRoleAssignments.md)
- [CollectionOfApplications](docs/Model/CollectionOfApplications.md)
- [CollectionOfClass](docs/Model/CollectionOfClass.md)
- [CollectionOfDriveItems](docs/Model/CollectionOfDriveItems.md)
- [CollectionOfDriveItems1](docs/Model/CollectionOfDriveItems1.md)
- [CollectionOfDrives](docs/Model/CollectionOfDrives.md)
- [CollectionOfDrives1](docs/Model/CollectionOfDrives1.md)
- [CollectionOfEducationClass](docs/Model/CollectionOfEducationClass.md)
- [CollectionOfEducationUser](docs/Model/CollectionOfEducationUser.md)
- [CollectionOfGroup](docs/Model/CollectionOfGroup.md)
- [CollectionOfPermissions](docs/Model/CollectionOfPermissions.md)
- [CollectionOfPermissionsWithAllowedValues](docs/Model/CollectionOfPermissionsWithAllowedValues.md)
- [CollectionOfSchools](docs/Model/CollectionOfSchools.md)
- [CollectionOfTags](docs/Model/CollectionOfTags.md)
- [CollectionOfUser](docs/Model/CollectionOfUser.md)
- [CollectionOfUsers](docs/Model/CollectionOfUsers.md)
- [Deleted](docs/Model/Deleted.md)
- [DirectoryObject](docs/Model/DirectoryObject.md)
- [Drive](docs/Model/Drive.md)
- [DriveItem](docs/Model/DriveItem.md)
- [DriveItemCreateLink](docs/Model/DriveItemCreateLink.md)
- [DriveItemInvite](docs/Model/DriveItemInvite.md)
- [DriveRecipient](docs/Model/DriveRecipient.md)
- [EducationClass](docs/Model/EducationClass.md)
- [EducationOrganization](docs/Model/EducationOrganization.md)
- [EducationSchool](docs/Model/EducationSchool.md)
- [EducationUser](docs/Model/EducationUser.md)
- [EducationUserReference](docs/Model/EducationUserReference.md)
- [Entity](docs/Model/Entity.md)
- [ExportPersonalDataRequest](docs/Model/ExportPersonalDataRequest.md)
- [FileSystemInfo](docs/Model/FileSystemInfo.md)
- [Folder](docs/Model/Folder.md)
- [FolderView](docs/Model/FolderView.md)
- [GeoCoordinates](docs/Model/GeoCoordinates.md)
- [Group](docs/Model/Group.md)
- [Hashes](docs/Model/Hashes.md)
- [Identity](docs/Model/Identity.md)
- [IdentitySet](docs/Model/IdentitySet.md)
- [Image](docs/Model/Image.md)
- [ItemReference](docs/Model/ItemReference.md)
- [MemberReference](docs/Model/MemberReference.md)
- [ObjectIdentity](docs/Model/ObjectIdentity.md)
- [OdataError](docs/Model/OdataError.md)
- [OdataErrorDetail](docs/Model/OdataErrorDetail.md)
- [OdataErrorMain](docs/Model/OdataErrorMain.md)
- [OpenGraphFile](docs/Model/OpenGraphFile.md)
- [PasswordChange](docs/Model/PasswordChange.md)
- [PasswordProfile](docs/Model/PasswordProfile.md)
- [Permission](docs/Model/Permission.md)
- [Photo](docs/Model/Photo.md)
- [Quota](docs/Model/Quota.md)
- [RemoteItem](docs/Model/RemoteItem.md)
- [SharePointIdentitySet](docs/Model/SharePointIdentitySet.md)
- [Shared](docs/Model/Shared.md)
- [SharingLink](docs/Model/SharingLink.md)
- [SharingLinkPassword](docs/Model/SharingLinkPassword.md)
- [SharingLinkType](docs/Model/SharingLinkType.md)
- [SpecialFolder](docs/Model/SpecialFolder.md)
- [TagAssignment](docs/Model/TagAssignment.md)
- [TagUnassignment](docs/Model/TagUnassignment.md)
- [Trash](docs/Model/Trash.md)
- [UnifiedRoleDefinition](docs/Model/UnifiedRoleDefinition.md)
- [UnifiedRolePermission](docs/Model/UnifiedRolePermission.md)
- [User](docs/Model/User.md)

## Authorization

### openId


### bearerAuth

- **Type**: Bearer authentication (plain)

## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `v1.0.4`
- Build package: `org.openapitools.codegen.languages.PhpNextgenClientCodegen`
