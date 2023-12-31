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

/**
 * Provide static functions for creating and validating issuers.
 *
 * @package    repository_ocis
 * @copyright  2018 Jan Dageförde (Learnweb, University of Münster)
 * @copyright  2023 ownCloud GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace repository_ocis;

use repository_ocis\configuration_exception;

/**
 * Provide static functions for creating and validating issuers.
 *
 * @package    repository_ocis
 * @copyright  2018 Jan Dageförde (Learnweb, University of Münster)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class issuer_management {
    /**
     * Check if an issuer provides all endpoints that are required by repository_ocis.
     * @param \core\oauth2\issuer $issuer An issuer.
     * @return bool True, if all endpoints exist; false otherwise.
     */
    public static function is_valid_issuer(\core\oauth2\issuer $issuer) {
        $endpointtoken = false;
        $endpointauth = false;
        $endpointuserinfo = false;
        $endpoints = \core\oauth2\api::get_endpoints($issuer);
        foreach ($endpoints as $endpoint) {
            $name = $endpoint->get('name');
            switch ($name) {
                case 'token_endpoint':
                    $endpointtoken = true;
                    break;
                case 'authorization_endpoint':
                    $endpointauth = true;
                    break;
                case 'userinfo_endpoint':
                    $endpointuserinfo = true;
                    break;
            }
        }
        return $endpointtoken && $endpointauth && $endpointuserinfo;
    }

    /**
     * If a webfinger URL is set for the oauth service/issue return it, otherwise return FALSE
     *
     * @param \core\oauth2\issuer $issuer
     * @return string|bool
     * @throws \coding_exception
     */
    public static function get_webfinger_url(\core\oauth2\issuer $issuer): string|bool {
        $endpoints = \core\oauth2\api::get_endpoints($issuer);
        foreach ($endpoints as $endpoint) {
            $name = $endpoint->get('name');
            if ($name === 'webfinger_endpoint') {
                return $endpoint->get('url');
            }
        }
        return false;
    }

    /**
     * Returns the parsed url parts of an endpoint of an issuer.
     * @param string $endpointname
     * @param \core\oauth2\issuer $issuer
     * @return array parseurl [scheme => https/http, host=>'hostname', port=>443, path=>'path']
     * @throws configuration_exception if an endpoint is undefined
     */
    public static function parse_endpoint_url(string $endpointname, \core\oauth2\issuer $issuer): array {
        $url = $issuer->get_endpoint_url($endpointname);
        if (empty($url)) {
            throw new configuration_exception(get_string('endpointnotdefined', 'repository_ocis', $endpointname));
        }
        return parse_url($url);
    }
}
