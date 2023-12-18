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
class ocis_management {
    public static function get_proxy_settings(): array {
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
     * @throws UnauthorizedException
     * @throws \coding_exception
     * @throws ForbiddenException
     * @throws BadRequestException
     * @throws NotFoundException
     * @throws InternalServerErrorException
     * @throws HttpException
     * @throws InvalidResponseException
     * @throws moodle_exception
     */
    public static function get_new_ocis_object(
        oauth2_issuer $oauth2issuer,
        string $accesstoken,
        array $proxysetting
    ): Ocis {
        $webfingerurl = issuer_management::get_webfinger_url($oauth2issuer);
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
                    $e->getMessage()
                );
            }
        } else {
            $baseurl = $oauth2issuer->get('baseurl');
            return new Ocis($baseurl, $accesstoken, ['proxy' => $proxysetting]);
        }
    }

    /**
     * @return array<Drive>
     * @throws BadRequestException
     * @throws ForbiddenException
     * @throws InvalidResponseException
     * @throws NotFoundException
     * @throws moodle_exception
     */
    public static function get_drives(
        Ocis $ocis,
        bool $showpersonaldrive,
        bool $showshares,
        bool $showprojectdrives
    ): array {
        $drives = [];
        try {
            if ($showpersonaldrive) {
                $drives = $ocis->getMyDrives(
                    DriveOrder::NAME,
                    OrderDirection::ASC,
                    DriveType::PERSONAL
                );
            }
            if ($showshares) {
                $drives = array_merge(
                    $drives,
                    $ocis->getMyDrives(
                        DriveOrder::NAME,
                        OrderDirection::ASC,
                        DriveType::VIRTUAL
                    )
                );
            }
            if ($showprojectdrives) {
                $drives = array_merge(
                    $drives,
                    $ocis->getMyDrives(
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

    public static function get_resource_list_item(OcisResource $resource, string $driveid, string $path): array {
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
            $listitem['path'] = $driveid .
                ":" . rtrim($path, '/') . "/" .
                ltrim($resource->getName(), '/');
            $listitem['thumbnail'] = $OUTPUT->image_url(file_folder_icon(90))->out(false);
        } else {
            $listitem['thumbnail'] = $OUTPUT->image_url(
                file_extension_icon($resource->getName(), 90)
            )->out(false);
        }
        return $listitem;
    }

    public static function get_breadcrumb_path(
        string $reponame,
        string $driveidandpath
    ): array {
        // The first breadcrumb is the repo.
        $breadcrumbpath = [
            [
                'name' => $reponame,
                'path' => '/',
            ],
        ];

        $driveidandpathobject = self::get_driveid_and_path($driveidandpath);
        // The second breadcrumb is the drive.
        if (!self::is_root($driveidandpath)) {
            $breadcrumbpath[] = [
                'name' => urldecode(self::get_drive_name($drive)),
                'path' => $driveidandpathobject->driveid,
            ];

            $chunks = explode('/', trim($driveidandpathobject->path, '/'));

            $parent = $driveidandpathobject->driveid . ':';
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

    private static function is_root(string $driveidandpath) {
        return ($driveidandpath === '' || $driveidandpath === '/');
    }

    private static function get_driveid_and_path(string $driveidandpath): \stdClass {
        $return = new \stdClass();
        // The colon ":" is the seperator between drive_id and path.
        $matches = explode(":", $driveidandpath, 2);
        $return->driveid = $matches[0];
        if (array_key_exists(1, $matches)) {
            $return->path = $matches[1];
        } else {
            $return->path = '';
        }


        return $return;
    }

    private static function get_drive_name(Drive $drive): string {
        if ($drive->getType() === DriveType::PERSONAL) {
            return get_string('personal_drive', 'repository_ocis');
        } else {
            return $drive->getName();
        }
    }

    public static function get_file_list(
        Ocis $ocis,
        string $driveidandpath,
        bool $showpersonaldrive,
        bool $showshares,
        bool $showprojectdrives
    ): array {
        $drives = self::get_drives(
            $ocis,
            $showpersonaldrive,
            $showshares,
            $showprojectdrives
        );
        if (self::is_root($driveidandpath)) {
            /** @var Drive $drive */
            foreach ($drives as $drive) {
                $listitem = self::get_drive_listitem($drive);
                if ($listitem !== null) {
                    $list["0" . strtoupper($drive->getId())] = $listitem;
                }
            }
        } else {
            // The colon ":" is the seperator between drive_id and path.
            $matches = explode(":", $driveidandpath, 2);
            $driveid = $matches[0];
            if (array_key_exists(1, $matches)) {
                $path = $matches[1];
            } else {
                $path = '';
            }

            try {
                $drive = $ocis->getDriveById($driveid);
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

            $drivename = self::get_drive_name($drive);

            try {
                $resources = $drive->getResources($path);
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
                    rtrim($drivename, '/') . "/" . ltrim($path, '/'),
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
                $listitem = self::get_resource_list_item($resource, $driveid, $path);
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
}
