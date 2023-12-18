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

    public static function get_drive_listitem(Drive $drive): array|null
    {
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
}
