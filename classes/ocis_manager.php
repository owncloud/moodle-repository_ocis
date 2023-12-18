<?php
// This file is part of the ocis repository for Moodle - http://moodle.org/
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

/**
 * Provide static functions for managing access to the oCIS server.
 *
 * @package    repository_ocis
 * @copyright  2023 ownCloud GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class ocis_manager {
    private oauth2_client $oauth2client;
    private oauth2_issuer $oauth2issuer;
    private string $driveidandpath;
    private bool $showpersonaldrive;
    private bool $showshares;
    private bool $showprojectdrives;
    private ?string $driveid = null;
    private string $path;
    private ?Drive $drive = null;

    /**
     * @throws ForbiddenException
     * @throws BadRequestException
     * @throws InvalidResponseException
     * @throws moodle_exception
     */
    public function __construct(
        oauth2_client $oauth2client,
        oauth2_issuer $oauth2issuer,
        string $driveidandpath,
        bool $showpersonaldrive,
        bool $showshares,
        bool $showprojectdrives
    ) {
        $this->oauth2client = $oauth2client;
        $this->oauth2issuer = $oauth2issuer;
        $this->driveidandpath = $driveidandpath;
        $this->showpersonaldrive = $showpersonaldrive;
        $this->showshares = $showshares;
        $this->showprojectdrives = $showprojectdrives;

        if (!$this->is_root()) {
            // The colon ":" is the seperator between drive_id and path.
            $matches = explode(":", $driveidandpath, 2);
            $this->driveid = $matches[0];
            if (array_key_exists(1, $matches)) {
                $this->path = $matches[1];
            } else {
                $this->path = '';
            }
            try {
                $this->drive = $this->getocisclient()->getDriveById($this->driveid);
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
    }
    private function getocisclient(): Ocis {
        $accesstoken = $this->oauth2client->get_accesstoken();
        if ($accesstoken === null) {
            throw new moodle_exception(
                'unauthorized_error',
                'repository_ocis'
            );
        }
        if ($this->ocis === null) {
            $proxysetting = ocis_management::get_proxy_settings();
            $this->ocis = ocis_management::get_new_ocis_object($this->oauth2issuer, $accesstoken->token, $proxysetting);
        } else {
            // Update the token for the ocis client, just in case it changed.
            $this->ocis->setAccessToken($accesstoken->token);
        }
        return $this->ocis;
    }

    /**
     * @return array<Drive>
     * @throws BadRequestException
     * @throws ForbiddenException
     * @throws InvalidResponseException
     * @throws NotFoundException
     * @throws moodle_exception
     */
    private function get_drives(): array {
        $drives = [];
        try {
            if ($this->showpersonaldrive) {
                $drives = $this->getocisclient()->getMyDrives(
                    DriveOrder::NAME,
                    OrderDirection::ASC,
                    DriveType::PERSONAL
                );
            }
            if ($this->showshares) {
                $drives = array_merge(
                    $drives,
                    $this->getocisclient()->getMyDrives(
                        DriveOrder::NAME,
                        OrderDirection::ASC,
                        DriveType::VIRTUAL
                    )
                );
            }
            if ($this->showprojectdrives) {
                $drives = array_merge(
                    $drives,
                    $this->getocisclient()->getMyDrives(
                        DriveOrder::NAME,
                        OrderDirection::ASC,
                        DriveType::PROJECT
                    )
                );
            }
        } catch (HttpException $e) {
            throw new moodle_exception(
                'could_not_connect_error',
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

    public static function get_drive_listitem(Drive $drive): array|null {
        global $OUTPUT;
        // Skip disabled drives.
        if ($drive->isDisabled()) {
            return null;
        }
        if ($drive->getType() === DriveType::PERSONAL) {
            $drivetitle = get_string('personal_drive', 'repository_ocis');
        } else if ($drive->getType() === DriveType::VIRTUAL) {
            $drivetitle = get_string('shares_drive', 'repository_ocis');
        } else {
            $drivetitle = $drive->getName();
        }
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
            'title' => $drivetitle,
            'datemodified' => $datemodified,
            'source' => $drive->getId(),
            'children' => [],
            'path' => $drive->getId(),
            'thumbnail' => $OUTPUT->image_url(file_folder_icon(90))->out(false),
            'size' => $size,
        ];
    }

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
            // The colon ":" is the seperator between drive_id and path.
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
                'path' => $this->driveid,
            ];

            $chunks = explode('/', trim($this->path, '/'));

            $parent = $this->driveid . ':';
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

    private function is_root() {
        return ($this->driveidandpath === '' || $this->driveidandpath === '/');
    }

    private function get_drive_name(): string {
        if ($this->drive->getType() === DriveType::PERSONAL) {
            return get_string('personal_drive', 'repository_ocis');
        } else {
            return $this->drive->getName();
        }
    }

    /**
     * @throws ForbiddenException
     * @throws BadRequestException
     * @throws NotFoundException
     * @throws InvalidResponseException
     * @throws moodle_exception
     */
    public function get_file_list(): array {
        if ($this->is_root()) {
            $drives = $this->get_drives();
            /** @var Drive $drive */
            foreach ($drives as $drive) {
                $listitem = self::get_drive_listitem($drive);
                if ($listitem !== null) {
                    $list["0" . strtoupper($drive->getId())] = $listitem;
                }
            }
        } else if ($this->drive !== null) {
            try {
                $resources = $this->drive->getResources($this->path);
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
        } else {
            throw new \Exception('Could not get drive-id!');
        }

        ksort($list);
        return $list;
    }

    public function get_manage_url(): string {
        if (!$this->is_root() && $this->drive !== null) {
            return $this->drive->getWebUrl();
        } else {
            return $this->oauth2issuer->get('baseurl');
        }
    }
}
