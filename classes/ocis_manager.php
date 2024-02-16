<?php
// This file is part of the ownCloud Infinite Scale for moodle Repository https://github.com/owncloud/moodle-repository_ocis
//
// The ocis repository for Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// The ocis repository for Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with the ocis repository for Moodle.  If not, see <http://www.gnu.org/licenses/>.
//
// ownCloud Infinite Scale for moodle Repository is built with the contributions of:
// - Staatsinstitut für Schulqualität und Bildungsforschung
// - JankariTech
// - ownCloud - a Kiteworks company.

namespace repository_ocis;

use DateTime;
use moodle_exception;
use core\oauth2\issuer as oauth2_issuer;
use core\oauth2\client as oauth2_client;
use Owncloud\OcisPhpSdk\Drive;
use Owncloud\OcisPhpSdk\DriveOrder;
use Owncloud\OcisPhpSdk\DriveType;
use Owncloud\OcisPhpSdk\Exception\BadRequestException;
use Owncloud\OcisPhpSdk\Exception\ForbiddenException;
use Owncloud\OcisPhpSdk\Exception\HttpException;
use Owncloud\OcisPhpSdk\Exception\InternalServerErrorException;
use Owncloud\OcisPhpSdk\Exception\InvalidResponseException;
use Owncloud\OcisPhpSdk\Exception\NotFoundException;
use Owncloud\OcisPhpSdk\Exception\UnauthorizedException;
use Owncloud\OcisPhpSdk\Ocis;
use Owncloud\OcisPhpSdk\OcisResource;
use Owncloud\OcisPhpSdk\OrderDirection;
use Owncloud\OcisPhpSdk\ShareReceived;

/**
 * Helper class to deal with oCIS
 * @package    repository_ocis
 * @copyright  2023 ownCloud GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class ocis_manager {
    /**
     * @var oauth2_client
     */
    private oauth2_client $oauth2client;
    /**
     * @var oauth2_issuer
     */
    private oauth2_issuer $oauth2issuer;
    /**
     * String containing the drive_id and the current path. The drive_id is separated from the path by a colon ":".
     * @var string|null
     */
    private ?string $driveidandpath = null;
    /**
     * Setting to determine if the personal drive should be listed.
     * @var bool
     */
    private bool $showpersonaldrive;
    /**
     * Setting to determine if received shares should be listed.
     * @var bool
     */
    private bool $showshares;
    /**
     * Setting to determine if project-drives should be listed.
     * @var bool
     */
    private bool $showprojectdrives;
    /**
     * The id of the currently browsed drive.
     * @var string|null
     */
    private ?string $driveid = null;
    /**
     * The currently browsed path.
     * @var string
     */
    private string $path;
    /**
     * The currently browsed drive.
     * @var Drive|null
     */
    private ?Drive $drive = null;
    /**
     * The main ocis object.
     * @var Ocis|null
     */
    private ?Ocis $ocis = null;
    /**
     * URL of the icon to be shown for the personal drive.
     * @var string|null
     */
    private ?string $personaldriveiconurl;
    /**
     * URL of the icon to be shown for the share drive.
     * @var string|null
     */
    private ?string $sharesiconurl;
    /**
     * URL of the icon to be shown for all project drives.
     * @var string|null
     */
    private ?string $projectdriveiconurl;

    /**
     * Creates a new ocis_manager
     *
     * @param oauth2_client $oauth2client
     * @param oauth2_issuer $oauth2issuer
     * @param bool $showpersonaldrive Setting to determine if the personal drive should be listed.
     * @param bool $showshares Setting to determine if received shares should be listed.
     * @param bool $showprojectdrives Setting to determine if project-drives should be listed.
     * @param string|null $personaldriveiconurl URL of the icon to be shown for the personal drive.
     * @param string|null $sharesiconurl URL of the icon to be shown for the share drive.
     * @param string|null $projectdriveiconurl URL of the icon to be shown for all project drives.
     */
    public function __construct(
        oauth2_client $oauth2client,
        oauth2_issuer $oauth2issuer,
        bool $showpersonaldrive,
        bool $showshares,
        bool $showprojectdrives,
        ?string $personaldriveiconurl,
        ?string $sharesiconurl,
        ?string $projectdriveiconurl
    ) {
        $this->oauth2client = $oauth2client;
        $this->oauth2issuer = $oauth2issuer;
        $this->showpersonaldrive = $showpersonaldrive;
        $this->showshares = $showshares;
        $this->showprojectdrives = $showprojectdrives;
        $this->personaldriveiconurl = $personaldriveiconurl;
        $this->sharesiconurl = $sharesiconurl;
        $this->projectdriveiconurl = $projectdriveiconurl;
    }

    /**
     * Returns the cached drive_id.
     * If no id is set yet, it will get a new drive object and return it's id.
     */
    private function get_drive_id(): string {
        if ($this->driveid === null) {
            $this->get_drive();
        }
        return $this->driveid;
    }

    /**
     * Returns the cached drive object.
     * If the Drive object does not exist yet, a new one will be created using the drive_id in $this->driveidanpath.
     *
     * @throws moodle_exception
     */
    private function get_drive(): Drive {
        if ($this->drive !== null) {
            return $this->drive;
        } else {
            // The colon ":" is the separator between drive_id and path.
            $matches = explode(":", $this->driveidandpath, 2);
            $this->driveid = $matches[0];
            if (array_key_exists(1, $matches)) {
                $this->path = $matches[1];
            } else {
                $this->path = '';
            }
            try {
                $this->drive = $this->get_ocis_client()->getDriveById($this->driveid);
            } catch (HttpException $e) {
                throw new moodle_exception(
                    'could_not_connect_error',
                    'repository_ocis',
                    '',
                    null,
                    $e->getTraceAsString()
                );
            } catch (NotFoundException $e) {
                throw new moodle_exception(
                    'drive_not_found_error',
                    'repository_ocis',
                    '',
                    null,
                    $e->getTraceAsString()
                );
            } catch (UnauthorizedException $e) {
                throw new moodle_exception(
                    'unauthorized_error',
                    'repository_ocis',
                    '',
                    null,
                    $e->getTraceAsString()
                );
            } catch (InternalServerErrorException $e) {
                throw new moodle_exception(
                    'internal_server_error',
                    'repository_ocis',
                    '',
                    null,
                    $e->getTraceAsString()
                );
            }
        }
        return $this->drive;
    }

    /**
     * Gets all drives that should be displayed to the user.
     *
     * @return array<Drive>
     * @throws moodle_exception
     */
    private function get_drives(): array {
        $drives = [];
        try {
            if ($this->showpersonaldrive) {
                $drives = $this->get_ocis_client()->getMyDrives(
                    DriveOrder::NAME,
                    OrderDirection::ASC,
                    DriveType::PERSONAL
                );
            }
            if ($this->showshares) {
                $drives = array_merge(
                    $drives,
                    $this->get_ocis_client()->getMyDrives(
                        DriveOrder::NAME,
                        OrderDirection::ASC,
                        DriveType::VIRTUAL
                    )
                );
            }
            if ($this->showprojectdrives) {
                $drives = array_merge(
                    $drives,
                    $this->get_ocis_client()->getMyDrives(
                        DriveOrder::NAME,
                        OrderDirection::ASC,
                        DriveType::PROJECT
                    )
                );
            }
        } catch (HttpException $e) {
            $this->oauth2client->log_out();
            throw new moodle_exception(
                'could_not_connect_error',
                'repository_ocis',
                '',
                null,
                $e->getTraceAsString() . " Message: " . $e->getMessage()
            );
        } catch (UnauthorizedException $e) {
            $this->oauth2client->log_out();
            throw new moodle_exception(
                'unauthorized_error_after_logout',
                'repository_ocis',
                '',
                null,
                $e->getTraceAsString() . " Message: " . $e->getMessage()
            );
        } catch (InternalServerErrorException $e) {
            $this->oauth2client->log_out();
            throw new moodle_exception(
                'internal_server_error',
                'repository_ocis',
                '',
                null,
                $e->getTraceAsString() . " Message: " . $e->getMessage()
            );
        }
        catch (\moodle_exception $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->oauth2client->log_out();
            throw new moodle_exception(
                'unrecoverable_server_error',
                'repository_ocis',
                '',
                null,
                $e->getTraceAsString() . " Message: " . $e->getMessage()
            );
        }

        if (empty($drives)) {
            throw new \moodle_exception(
                'no_drives_error',
                'repository_ocis',
                '',
                null
            );
        }
        return $drives;
    }

    /**
     * Uses the given Drive object to create an item for the list in the file-picker.
     * @param Drive $drive
     * @return array<mixed>|null
     */
    private function get_drive_list_item(Drive $drive): array|null {
        global $OUTPUT;
        // Skip disabled drives.
        if ($drive->isDisabled()) {
            return null;
        }
        if ($drive->getType() === DriveType::PERSONAL) {
            if ($this->personaldriveiconurl === null || trim($this->personaldriveiconurl) === '') {
                $thumbnail = $OUTPUT->image_url('resource-type-folder-fill', 'repository_ocis')->out(false);
            } else {
                $thumbnail = $this->personaldriveiconurl;
            }
        } else if ($drive->getType() === DriveType::VIRTUAL) {
            if ($this->sharesiconurl === null || trim($this->sharesiconurl) === '') {
                $thumbnail = $OUTPUT->image_url('share-forward-fill', 'repository_ocis')->out(false);
            } else {
                $thumbnail = $this->sharesiconurl;
            }
        } else {
            if ($this->projectdriveiconurl === null || trim($this->projectdriveiconurl) === '') {
                $thumbnail = $OUTPUT->image_url('layout-grid-fill', 'repository_ocis')->out(false);
            } else {
                $thumbnail = $this->projectdriveiconurl;
            }
        }
        $icon = $thumbnail;
        try {
            $size = (int)$drive->getQuota()->getUsed();
        } catch (InvalidResponseException $e) {
            // The Share drive does not return a Quota.
            $size = 0;
        }
        try {
            $datemodified = $drive->getLastModifiedDateTime()->getTimestamp();
        } catch (InvalidResponseException $e) {
            $datemodified = "";
        }

        return [
            'title' => $this->get_drive_name($drive),
            'datemodified' => $datemodified,
            'source' => $drive->getId(),
            'children' => [],
            'path' => $drive->getId(),
            'thumbnail' => $thumbnail,
            'icon' => $icon,
            'size' => $size,
        ];
    }

    /**
     * Gets the name of the drive, or in the case of the personal/shares drive the translated string.
     * @param ?Drive $drive if null use get_drive() to find the current drive
     */
    private function get_drive_name(?Drive $drive = null): string {
        if ($drive === null) {
            $drive = $this->get_drive();
        }
        if ($drive->getType() === DriveType::PERSONAL) {
            return get_string('personal_drive', 'repository_ocis');
        } else if ($drive->getType() === DriveType::VIRTUAL) {
            return get_string('shares_drive', 'repository_ocis');
        } else {
            return $drive->getName();
        }
    }

    /**
     * Returns the proxy settings of moodle in a format that can be passed to the OCIS-PHP-SDK.
     */
    private function get_proxy_settings(): array {
        global $CFG;

        if (empty($CFG->proxyhost)) {
            return [];
        } else {
            $proxyhost = $CFG->proxyhost;
            if (!empty($CFG->proxyport)) {
                $proxyhost = "{$CFG->proxyhost}:{$CFG->proxyport}";
            }

            $proxyauth = "";
            if (!empty($CFG->proxyuser) && !empty($CFG->proxypassword)) {
                $proxyauth = "{$CFG->proxyuser}:{$CFG->proxypassword}@";
            }

            $protocol = "http://";
            if (!empty($CFG->proxytype) && $CFG->proxytype === 'SOCKS5') {
                $protocol = "socks5://";
            }

            $proxystring = "{$protocol}{$proxyauth}{$proxyhost}";
            $noproxy = [];

            if (!empty($CFG->proxybypass)) {
                $noproxy = array_map(function (string $hostname): string {
                    return trim($hostname);
                }, explode(',', $CFG->proxybypass));
            }

            return [
                'http' => $proxystring,
                'https' => $proxystring,
                'no' => $noproxy,
            ];
        }
    }

    /**
     * Creates and returns a new Ocis object.
     * @param string $accesstoken
     * @param array $proxysetting
     * @throws moodle_exception
     */
    private function get_new_ocis_object(
        string $accesstoken,
        array $proxysetting
    ): Ocis {
        $webfingerurl = issuer_management::get_webfinger_url($this->oauth2issuer);
        if ($webfingerurl) {
            try {
                return new Ocis(
                    $webfingerurl,
                    $accesstoken,
                    [
                        'webfinger' => true,
                        'proxy' => $proxysetting,
                    ]
                );
            } catch (InternalServerErrorException $e) {
                throw new moodle_exception(
                    'internal_server_error',
                    'repository_ocis',
                    '',
                    null,
                    $e->getTraceAsString()
                );
            } catch (\Exception $e) {
                throw new moodle_exception(
                    'webfinger_error',
                    'repository_ocis',
                    '',
                    null,
                    $e->getTraceAsString() . " Message: " . $e->getMessage()
                );
            }
        } else {
            $baseurl = $this->oauth2issuer->get('baseurl');
            return new Ocis($baseurl, $accesstoken, ['proxy' => $proxysetting]);
        }
    }

    /**
     * Setter for $this->driveidandpath
     * @param string $driveidandpath
     */
    public function set_driveid_and_path(string $driveidandpath): void {
        $this->driveidandpath = $driveidandpath;
    }

    /**
     * Determines if the user currently browses the root of the oCIS instance (true) or is browsing inside of a drive (false).
     */
    private function is_root(): bool {
        return ($this->driveidandpath === '' || $this->driveidandpath === '/');
    }

    /**
     * Returns a cached Ocis object.
     * If the object exists it will update the access token, if it does not exist it will create one.
     * @throws moodle_exception
     */
    public function get_ocis_client(): Ocis {
        $accesstoken = $this->oauth2client->get_accesstoken();
        if ($accesstoken === null) {
            throw new moodle_exception(
                'unauthorized_error',
                'repository_ocis'
            );
        }
        if ($this->ocis === null) {
            $proxysetting = $this->get_proxy_settings();

            $this->ocis = $this->get_new_ocis_object($accesstoken->token, $proxysetting);
        } else {
            // Update the token for the ocis client, just in case it changed.
            $this->ocis->setAccessToken($accesstoken->token);
        }
        return $this->ocis;
    }

    /**
     * Uses the given OcisResource object to create an item for the list in the file-picker.
     * @param OcisResource $resource
     * @return array<mixed>
     */
    public function get_resource_list_item(OcisResource $resource): array {
        global $OUTPUT;
        try {
            $lastmodifiedtime = new DateTime($resource->getLastModifiedTime());
            $datemodified = $lastmodifiedtime->getTimestamp();
        } catch (InvalidResponseException $e) {
            $datemodified = "";
        }

        $listitem = [
            'title' => $resource->getName(),
            'date' => $datemodified,
            'size' => $resource->getSize(),
            'source' => $resource->getId(),
        ];
        if ($resource->getType() === 'folder') {
            $listitem['children'] = [];
            // The colon ":" is the separator between drive_id and path.
            $listitem['path'] = $this->driveid .
                ":" . rtrim($this->path, '/') . "/" .
                ltrim($resource->getName(), '/');
            $listitem['thumbnail'] = $OUTPUT->image_url(file_folder_icon(90))->out(false);
        } else {
            $listitem['thumbnail'] = $OUTPUT->image_url(
                file_extension_icon($resource->getName(), 90)
            )->out(false);
        }
        return $listitem;
    }

    /**
     * Gets the breadcrumb path in the format that is used by the file-picker.
     * @param string $reponame
     */
    public function get_breadcrumb_path(
        string $reponame
    ): array {
        // The first breadcrumb is the repo.
        $breadcrumbpath = [
            [
                'name' => $reponame,
                'path' => '/',
            ],
        ];

        // The second breadcrumb is the drive.
        if (!$this->is_root()) {
            $breadcrumbpath[] = [
                'name' => urldecode($this->get_drive_name()),
                'path' => $this->get_drive_id(),
            ];

            $chunks = explode('/', trim($this->path, '/'));

            $parent = $this->get_drive_id() . ':';
            // Every sub-path to the last part of the current path is a parent path.
            foreach ($chunks as $chunk) {
                if ($chunk === '') {
                    continue;
                }
                $subpath = $parent . $chunk . '/';
                $breadcrumbpath[] = [
                    'name' => urldecode($chunk),
                    'path' => $subpath,
                ];
                // Prepare next iteration.
                $parent = $subpath;
            }
        }
        return $breadcrumbpath;
    }

    /**
     * Returns the complete file list for the currently browsed path.
     * @throws moodle_exception
     */
    public function get_file_list(): array {
        $list = [];
        if ($this->is_root()) {
            $drives = $this->get_drives();
            /** @var Drive $drive */
            foreach ($drives as $drive) {
                $listitem = $this->get_drive_list_item($drive);
                if ($listitem !== null) {
                    $list["0" . strtoupper($drive->getId())] = $listitem;
                }
            }
        } else {
            try {
                $receivedshares = null;
                $resources = $this->get_drive()->getResources($this->path);
                if ($this->get_drive()->getType() === DriveType::VIRTUAL) {
                    $receivedshares = $this->get_ocis_client()->getSharedWithMe();
                }
            } catch (HttpException $e) {
                throw new moodle_exception(
                    'could_not_connect_error',
                    'repository_ocis',
                    '',
                    null,
                    $e->getTraceAsString()
                );
            } catch (NotFoundException $e) {
                throw new moodle_exception(
                    'not_found_error',
                    'repository_ocis',
                    '',
                    rtrim($this->get_drive_name(), '/') . "/" . ltrim($this->path, '/'),
                    $e->getTraceAsString()
                );
            } catch (UnauthorizedException $e) {
                throw new moodle_exception(
                    'unauthorized_error',
                    'repository_ocis',
                    '',
                    null,
                    $e->getTraceAsString()
                );
            } catch (InternalServerErrorException $e) {
                throw new moodle_exception(
                    'internal_server_error',
                    'repository_ocis',
                    '',
                    null,
                    $e->getTraceAsString()
                );
            }

            /** @var OcisResource $resource */
            foreach ($resources as $resource) {
                if ($receivedshares !== null) {
                    foreach ($receivedshares as $share) {
                        if (
                            $share->isClientSyncronize() === true &&
                            $share->getId() === $resource->getId() &&
                            $share->isUiHidden() === true
                        ) {
                            continue(2);
                        }
                    }
                }
                $listitem = $this->get_resource_list_item($resource);
                if ($resource->getType() === 'folder') {
                    // This is to help with sorting, `0` is to make sure folders are on top
                    // then the name in uppercase to sort everything alphabetically with ksort.
                    $list["0" . strtoupper($resource->getName())] = $listitem;
                } else {
                    // This is to help with sorting, for sorting, `1` to make sure files are listed after folders.
                    $list["1" . strtoupper($resource->getName())] = $listitem;
                }
            }
        }
        ksort($list);
        return $list;
    }

    /**
     * Returns the URL to access the webUI of the oCIS instance.
     * If the user browses a drive, the web URL of the drive is returned.
     * Else the base URL of the instance is returned.
     *
     */
    public function get_manage_url(): string {
        if (!$this->is_root()) {
            return $this->get_drive()->getWebUrl();
        } else {
            return $this->get_ocis_client()->getServiceUrl();
        }
    }
}
