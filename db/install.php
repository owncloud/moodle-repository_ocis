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
/**
 * Installation function for the oCIS repository plugin.
 *
 * @package    repository_ocis
 * @copyright  2023 ownCloud GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function xmldb_repository_ocis_install() {
    global $CFG, $USER;
    $result = true;
    require_once($CFG->dirroot . '/repository/lib.php');
    $ocisplugin = new repository_type('ocis', [], true);
    if (!$id = $ocisplugin->create(true)) {
        $result = false;
    }
    if (strtolower(getenv('MOODLE_DISABLE_CURL_SECURITY')) === 'true') {
        set_config('curlsecurityblockedhosts', '');
        set_config('curlsecurityallowedport', '');
    }

    $ocisurl = getenv('MOODLE_OCIS_URL');
    $ocislogourl = getenv('MOODLE_OCIS_LOGO_URL');
    $clientid = getenv('MOODLE_OCIS_CLIENT_ID');
    $clientsecret = getenv('MOODLE_OCIS_CLIENT_SECRET');
    if ($ocisurl !== false && $clientsecret !== false && $clientid !== false) {
        $issuerdata = new \stdClass();
        $issuerdata->name = "oCIS";
        $issuerdata->clientid = $clientid;
        $issuerdata->clientsecret = $clientsecret;
        $issuerdata->loginscopes = "openid profile email";
        $issuerdata->loginscopesoffline = "openid profile email offline_access";
        $issuerdata->baseurl = $ocisurl;
        if (!$ocislogourl) {
            $issuerdata->image = $ocisurl . '/themes/owncloud/assets/logo_dark.svg';
        } else {
            $issuerdata->image = $ocislogourl;
        }


        $issuer = core\oauth2\api::create_issuer($issuerdata);
        $result = $issuer->is_valid();
        if (!$result) {
            return $result;
        }
        $repo = repository::create(
            'ocis',
            $USER->id,
            context_system::instance(),
            [
                'name' => 'oCIS',
                'issuerid' => $issuer->get('id'),
            ]
        );
        if ($repo === null) {
            $result = false;
        }
    }
    return $result;
}
