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
 * Language strings' definition for ocis repository.
 *
 * @package    repository_ocis
 * @copyright  2017 Project seminar (Learnweb, University of Münster)
 * @copyright  2023 ownCloud GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'ownCloud Infinite Scale repository';
$string['configplugin'] = 'ownCloud Infinite Scale repository configuration';
$string['ocis'] = 'ownCloud Infinite Scale';
$string['ocis:view'] = 'View ownCloud Infinite Scale';
$string['pluginname_help'] = 'ownCloud Infinite Scale repository';

// Settings.
$string['chooseissuer'] = 'Issuer';
$string['right_issuers'] = 'The following issuers implement the required endpoints: <br> {$a}';
$string['no_right_issuers'] = 'None of the existing issuers implement all required endpoints. Please register an appropriate issuer.';
$string['chooseissuer_help'] = 'To add a new issuer, go to Site administration / Server / OAuth 2 services.';
$string['oauth2serviceslink'] = '<a href="{$a}" title="Link to OAuth 2 services configuration">OAuth 2 services configuration</a>';
$string['privacy:metadata'] = 'The ownCloud Infinite Scale repository plugin neither stores any personal data nor transmits user data to the remote system.';
$string['show_personal_drive'] = 'Show personal drive';
$string['show_shares'] = 'Show shares';
$string['show_project_drives'] = 'Show project drives';
$string['personal_drive_icon_url'] = 'Icon URL for personal drive';
$string['shares_icon_url'] = 'Icon URL for shares';
$string['project_drives_icon_url'] = 'Icon URL for project drives';


// Filepicker.
$string['no_drives_error'] = 'No drives found.';
$string['drive_not_found_error'] = 'Could not find this drive.';
$string['not_found_error'] = 'Could not find "{$a}".';
$string['too_early_error'] = 'This file is still processed by the ownCloud Infinite Scale server. Please try again later.';
$string['could_not_connect_error'] = 'Could not connect to ownCloud Infinite Scale server.';
$string['internal_server_error'] = 'The ownCloud Infinite Scale server has an internal problem. Please try again later.';
$string['unauthorized_error'] = 'Authorization to ownCloud Infinite Scale server failed. Please try to logout of the repository and login again.';
$string['unauthorized_error_after_logout'] = 'Authorization to ownCloud Infinite Scale server failed. Please try to login again.';
$string['unrecoverable_server_error'] = 'The ownCloud Infinite Scale server ran into a problem. Please try to login again.';
$string['webfinger_error'] = 'Could not get user-information from webfinger service.';
$string['personal_drive'] = 'Personal';
$string['shares_drive'] = 'Shares';
