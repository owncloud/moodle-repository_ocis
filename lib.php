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
 * oCIS repository plugin library.
 *
 * @package    repository_ocis
 * @copyright  2017 Project seminar (Learnweb, University of Münster)
 * @copyright  2023 ownCloud GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\oauth2\api as oauth2_api;
use core\oauth2\client as oauth2_client;
use core\oauth2\issuer as oauth2_issuer;
use Owncloud\OcisPhpSdk\Exception\BadRequestException;
use Owncloud\OcisPhpSdk\Exception\ForbiddenException;
use Owncloud\OcisPhpSdk\Exception\InternalServerErrorException;
use Owncloud\OcisPhpSdk\Exception\InvalidResponseException;
use Owncloud\OcisPhpSdk\Exception\HttpException;
use Owncloud\OcisPhpSdk\Exception\NotFoundException;
use Owncloud\OcisPhpSdk\Exception\TooEarlyException;
use Owncloud\OcisPhpSdk\Exception\UnauthorizedException;
use repository_ocis\issuer_management;
use repository_ocis\ocis_manager;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/vendor/autoload.php');
require_once($CFG->dirroot . '/repository/lib.php');

/**
 * oCIS repository class.
 *
 * @package    repository_ocis
 * @copyright  2017 Project seminar (Learnweb, University of Münster)
 * @copyright  2023 ownCloud GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class repository_ocis extends repository {
    /**
     * OAuth 2 Issuer used by this repo.
     * @var ?oauth2_issuer
     */
    private ?oauth2_issuer $oauth2issuer;

    /**
     * OAuth 2 client used by this repo.
     * @var ?oauth2_client
     */
    private ?oauth2_client $oauth2client = null;

    /**
     * Main object that manages the access to the oCIS instance.
     * @var ?ocis_manager
     */
    private ?ocis_manager $ocismanager = null;

    /**
     * repository_ocis constructor.
     *
     * @param int $repositoryid
     * @param bool|int|stdClass $context
     * @param array $options
     * @throws coding_exception|dml_exception
     */
    public function __construct($repositoryid, $context = SYSCONTEXTID, $options = []) {
        parent::__construct($repositoryid, $context, $options);
        // Issuer from repository instance config.
        $issuerid = $this->get_option('issuerid');
        try {
            $this->oauth2issuer = oauth2_api::get_issuer($issuerid);
        } catch (dml_missing_record_exception $e) {
            // A repository is marked as disabled when no issuer is present.
            $this->disabled = true;
            return;
        }
        if (!$this->oauth2issuer) {
            $this->disabled = true;
            return;
        } else if (!$this->oauth2issuer->get('enabled')) {
            // In case the Issuer is not enabled, the repository is disabled.
            $this->disabled = true;
            return;
        } else if (!issuer_management::is_valid_issuer($this->oauth2issuer)) {
            // Check if necessary endpoints are present.
            $this->disabled = true;
            return;
        }
    }

    /**
     * Returns the cached oCIS manager object.
     */
    private function getocismanager(): ocis_manager {
        if ($this->ocismanager === null) {
            $this->ocismanager = new ocis_manager(
                $this->get_user_oauth_client(),
                $this->oauth2issuer,
                ($this->get_option('show_personal_drive') === "1"),
                ($this->get_option('show_shares') === "1"),
                ($this->get_option('show_project_drives') === "1"),
                $this->get_option('personal_drive_icon_url'),
                $this->get_option('shares_icon_url'),
                $this->get_option('project_drives_icon_url')
            );
        }

        return $this->ocismanager;
    }

    /**
     * Get file listing.
     *
     * This is a mandatory method for any repository.
     *
     * See repository::get_listing() for details.
     *
     * @param string $driveidandpath The drive it is seperated by ":" from the path
     * @param string $page
     * @return array the list of files, including meta information
     * @throws Exception
     */
    public function get_listing($driveidandpath = '', $page = '') {
        $ocismanager = $this->getocismanager();
        $ocismanager->set_driveid_and_path($driveidandpath);

        $list = $ocismanager->get_file_list();
        $breadcrumbpath = $ocismanager->get_breadcrumb_path(
            $this->get_meta()->name
        );

        return [
            // This will be used to build navigation bar.
            'dynload' => true,
            'nosearch' => true,
            'path' => $breadcrumbpath,
            'manage' => $ocismanager->get_manage_url(),
            'list' => $list,
        ];
    }

    /**
     * This method adds a select form and additional information to the settings form..
     *
     * @param MoodleQuickForm $mform Moodle form (passed by reference)
     * @return bool|void
     * @throws coding_exception
     * @throws dml_exception
     */
    public static function instance_config_form($mform) {
        if (!has_capability('moodle/site:config', context_system::instance())) {
            $mform->addElement('static', null, '', get_string('nopermissions', 'error', get_string(
                'configplugin',
                'repository_ocis'
            )));
            return false;
        }

        // Load configured issuers.
        $issuers = core\oauth2\api::get_all_issuers();
        $types = [];

        // Validates which issuers implement the right endpoints.
        $validissuers = [];
        foreach ($issuers as $issuer) {
            $types[$issuer->get('id')] = $issuer->get('name');
            if (\repository_ocis\issuer_management::is_valid_issuer($issuer)) {
                $validissuers[] = $issuer->get('name');
            }
        }

        // Render the form.
        $url = new \moodle_url('/admin/tool/oauth2/issuers.php');
        $mform->addElement('static', null, '', get_string('oauth2serviceslink', 'repository_ocis', $url->out()));

        $mform->addElement('select', 'issuerid', get_string('chooseissuer', 'repository_ocis'), $types);
        $mform->addRule('issuerid', get_string('required'), 'required', null, 'issuer');
        $mform->addHelpButton('issuerid', 'chooseissuer', 'repository_ocis');
        $mform->setType('issuerid', PARAM_INT);

        // All issuers that are valid are displayed separately (if any).
        if (count($validissuers) === 0) {
            $mform->addElement('static', null, '', get_string('no_right_issuers', 'repository_ocis'));
        } else {
            $mform->addElement('static', null, '', get_string(
                'right_issuers',
                'repository_ocis',
                implode(', ', $validissuers)
            ));
        }

        $mform->addElement(
            'selectyesno',
            'show_personal_drive',
            get_string('show_personal_drive', 'repository_ocis')
        );
        $mform->setDefault('show_personal_drive', 1);
        $mform->addElement(
            'selectyesno',
            'show_shares',
            get_string('show_shares', 'repository_ocis')
        );
        $mform->setDefault('show_shares', 1);

        $mform->addElement(
            'selectyesno',
            'show_project_drives',
            get_string('show_project_drives', 'repository_ocis')
        );

        $mform->setDefault('show_project_drives', 1);

        $mform->addElement(
            'text',
            'personal_drive_icon_url',
            get_string('personal_drive_icon_url', 'repository_ocis')
        );
        $mform->setType('personal_drive_icon_url', PARAM_TEXT);

        $mform->addElement(
            'text',
            'shares_icon_url',
            get_string('shares_icon_url', 'repository_ocis')
        );
        $mform->setType('shares_icon_url', PARAM_TEXT);

        $mform->addElement(
            'text',
            'project_drives_icon_url',
            get_string('project_drives_icon_url', 'repository_ocis')
        );
        $mform->setType('project_drives_icon_url', PARAM_TEXT);
    }

    /**
     * Get a cached user authenticated oauth client.
     *
     * @param bool|moodle_url $overrideurl Use this url instead of the repo callback.
     * @return oauth2_client
     */
    protected function get_user_oauth_client($overrideurl = false) {
        if ($this->oauth2client) {
            return $this->oauth2client;
        }
        if ($overrideurl) {
            $returnurl = $overrideurl;
        } else {
            $returnurl = new moodle_url('/repository/repository_callback.php');
            $returnurl->param('callback', 'yes');
            $returnurl->param('repo_id', $this->id);
            $returnurl->param('sesskey', sesskey());
        }
        $this->oauth2client = oauth2_api::get_user_oauth_client($this->oauth2issuer, $returnurl, '', true);
        return $this->oauth2client;
    }

    /**
     * Prints a simple Login Button which redirects to an authorization window of ocis.
     *
     * @return array<mixed> login window properties.
     * @throws coding_exception
     */
    public function print_login(): array {
        $client = $this->get_user_oauth_client();
        $loginurl = $client->get_login_url();
        if ($this->options['ajax']) {
            $ret = [];
            $btn = new \stdClass();
            $btn->type = 'popup';
            $btn->url = $loginurl->out(false);
            $ret['login'] = [$btn];
            return $ret;
        } else {
            echo html_writer::link(
                $loginurl,
                get_string('login', 'repository'),
                ['target' => '_blank', 'rel' => 'noopener noreferrer']
            );
        }
        return [];
    }

    /**
     * Sets up access token after the redirection from ocis.
     */
    public function callback() {
        $client = $this->get_user_oauth_client();
        // If an Access Token is stored within the client, it has to be deleted to prevent the addition
        // of an Bearer authorization header in the request method.
        $client->log_out();

        // This will upgrade to an access token if we have an authorization code and save the access token in the session.
        $client->is_logged_in();
    }

    /**
     * Deletes the held Access Token and prints the Login window.
     *
     * @return array login window properties.
     */
    public function logout() {
        $client = $this->get_user_oauth_client();
        $client->log_out();
        return parent::logout();
    }

    /**
     * Function which checks whether the user is logged in on the ocis instance.
     *
     * @return bool false, if no Access Token is set or can be requested.
     */
    public function check_login() {
        $client = $this->get_user_oauth_client();
        return $client->is_logged_in();
    }

    /**
     * Tells how the file can be picked from this repository.
     *
     * @return int
     */
    public function supported_returntypes() {
        return FILE_INTERNAL;
    }

    /**
     * Which return type should be selected by default.
     *
     * @return int
     */
    public function default_returntype() {
        return FILE_INTERNAL;
    }

    /**
     * Names of the plugin settings
     *
     * @return array
     */
    public static function get_instance_option_names() {
        return ['issuerid', 'controlledlinkfoldername',
            'defaultreturntype', 'supportedreturntypes',
            'show_personal_drive', 'show_shares', 'show_project_drives',
            'personal_drive_icon_url', 'shares_icon_url', 'project_drives_icon_url', 'sortorder'];
    }

    /**
     * Gets a file from oCIS, stores it locally and returns the path and fileid.
     * Moodle calls this method to retrieve the file that the user selected from a remote server.
     *
     * @see https://moodledev.io/docs/4.2/apis/plugintypes/repository#get_fileurl-filename--
     *
     * @param string $fileid
     * @param string $filename
     * @return array
     * @throws BadRequestException
     * @throws ForbiddenException
     * @throws InvalidResponseException
     * @throws coding_exception
     * @throws moodle_exception
     */
    public function get_file($fileid, $filename = ''): array {
        $localpath = $this->prepare_file($fileid);
        try {
            $file = $this->getocismanager()->get_ocis_client()->getResourceById($fileid);
            file_put_contents($localpath, $file->getContentStream());
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
                $filename,
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
        } catch (TooEarlyException $e) {
            throw new moodle_exception(
                'too_early_error',
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
        return ['path' => $localpath, 'url' => $fileid];
    }
}
