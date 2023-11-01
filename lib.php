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
 * oCIS repository plugin library.
 *
 * @package    repository_ocis
 * @copyright  2017 Project seminar (Learnweb, University of Münster)
 * @copyright  2023 ownCloud GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or
 */

use core\oauth2\api as oauth2_api;
use core\oauth2\client as oauth2_client;
use core\oauth2\issuer as oauth2_issuer;
use Owncloud\OcisPhpSdk\Drive;
use Owncloud\OcisPhpSdk\DriveType;
use Owncloud\OcisPhpSdk\Ocis;
use Owncloud\OcisPhpSdk\OcisResource;
use repository_ocis\issuer_management;

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
     * Main object to access the oCIS instance.
     * @var ?Ocis
     */
    private ?Ocis $ocis = null;

    /**
     * repository_ocis constructor.
     *
     * @param int $repositoryid
     * @param bool|int|stdClass $context
     * @param array $options
     */
    public function __construct($repositoryid, $context = SYSCONTEXTID, $options = []) {
        if (strtolower(getenv('MOODLE_DISABLE_CURL_SECURITY')) === 'true') {
            set_config('curlsecurityblockedhosts', '');
            set_config('curlsecurityallowedport', '');
        }
        parent::__construct($repositoryid, $context, $options);
        // Issuer from repository instance config.
        $issuerid = $this->get_option('issuerid');
        $this->oauth2issuer = oauth2_api::get_issuer($issuerid);

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
     * Returns the oCIS client object.
     * This function will create a new client if none exists or update the token if it changed,
     * that way it makes sure that always the current token is used.
     *
     * @throws coding_exception
     * @throws \Exception
     */
    private function getocisclient(): Ocis {
        $accesstoken = $this->get_user_oauth_client()->get_accesstoken();

        if ($this->ocis === null) {
            $webfingerurl = issuer_management::get_webfinger_url($this->oauth2issuer);
            if ($webfingerurl) {
                try {
                    $this->ocis = new Ocis($webfingerurl, $accesstoken->token, ['webfinger' => true]);
                } catch (\Exception $e) {
                    throw new \moodle_exception(
                        'webfinger_error',
                        'repository_ocis',
                        '',
                        null,
                        $e->getMessage()
                    );
                }
            } else {
                $baseurl = $this->oauth2issuer->get('baseurl');
                $this->ocis = new Ocis($baseurl, $accesstoken->token);
            }
        } else {
            // Update the token for the ocis client, just in case it changed.
            $this->ocis->setAccessToken($accesstoken->token);
        }
        return $this->ocis;
    }
    /**
     * Get file listing.
     *
     * This is a mandatory method for any repository.
     *
     * See repository::get_listing() for details.
     *
     * @param string $path
     * @param string $page
     * @return array the list of files, including meta information
     * @throws Exception
     */
    public function get_listing($path = '', $page = '') {
        global $OUTPUT;
        if ($path === "") {
            $path = '/';
        }

        $ocis = $this->getOcisClient();
        $drives = $ocis->listMyDrives();

        /** @var ?Drive $personaldrive */
        $personaldrive = null;
        /** @var Drive $drive */
        foreach ($drives as $drive) {
            if ($drive->getType() === DriveType::PERSONAL) {
                $personaldrive = $drive;
                break;
            }
        }
        if ($personaldrive === null) {
            throw new Exception(get_string('no_personal_drive_found', 'repository_ocis'));
        }
        $resources = $personaldrive->listResources($path);

        $list = [];
        /** @var OcisResource $resource */
        foreach ($resources as $resource) {
            $lastmodifiedtime = new DateTime($resource->getLastModifiedTime());
            $listitem = [
                'title' => $resource->getName(),
                'date' => $lastmodifiedtime->getTimestamp(),
                'size' => $resource->getSize(),
                'source' => $resource->getId(),
            ];
            if ($resource->getType() === 'folder') {
                $listitem['children'] = [];
                $listitem['path'] = $path . "/" . $resource->getName();
                $listitem['thumbnail'] = $OUTPUT->image_url(file_folder_icon(90))->out(false);

                // This is to help with sorting, `0` is to make sure folders are on top
                // then the name in uppercase to sort everything alphabetically with ksort.
                $list["0" . strtoupper($resource->getName())] = $listitem;
            } else {
                $listitem['thumbnail'] = $OUTPUT->image_url(
                    file_extension_icon($resource->getName(), 90)
                )->out(false);

                // This is to help with sorting, for sorting, `1` to make sure files are listed after folders.
                $list["1" . strtoupper($resource->getName())] = $listitem;
            }
        }

        $breadcrumbpath = [
            [
                'name' => $this->get_meta()->name,
                'path' => '/',
            ],
        ];
        if ($path !== '/') {
            $chunks = explode('/', trim($path, '/'));
            $parent = '/';
            // Every sub-path to the last part of the current path is a parent path.
            foreach ($chunks as $chunk) {
                $subpath = $parent . $chunk . '/';
                $breadcrumbpath[] = [
                    'name' => urldecode($chunk),
                    'path' => $subpath,
                ];
                // Prepare next iteration.
                $parent = $subpath;
            }
        }
        ksort($list);
        return [
            // This will be used to build navigation bar.
            'dynload' => true,
            'nosearch' => true,
            'path' => $breadcrumbpath,
            'manage' => $personaldrive->getWebUrl(),
            'list' => $list,
        ];
    }

    /**
     * This method adds a select form and additional information to the settings form..
     *
     * @param \moodleform $mform Moodle form (passed by reference)
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
            'defaultreturntype', 'supportedreturntypes', ];
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
     * @throws \Owncloud\OcisPhpSdk\Exception\BadRequestException
     * @throws \Owncloud\OcisPhpSdk\Exception\ForbiddenException
     * @throws \Owncloud\OcisPhpSdk\Exception\HttpException
     * @throws \Owncloud\OcisPhpSdk\Exception\NotFoundException
     * @throws \Owncloud\OcisPhpSdk\Exception\UnauthorizedException
     * @throws coding_exception
     */
    public function get_file($fileid, $filename = ''): array {
        $ocis = $this->getOcisClient();

        $localpath = $this->prepare_file($fileid);
        $stream = $ocis->getFileStreamById($fileid);
        file_put_contents($localpath, $stream);
        return ['path' => $localpath, 'url' => $fileid];
    }
}
