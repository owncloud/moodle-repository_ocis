<?php

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

require_once (__DIR__ . '/vendor/autoload.php');
require_once($CFG->dirroot . '/repository/lib.php');

class repository_ocis extends repository {
    private ?oauth2_issuer $oauth2_issuer;
    private ?oauth2_client $oauth2_client = null;
    private ?Ocis $ocis = null;

    /**
     * repository_ocis constructor.
     *
     * @param int $repositoryid
     * @param bool|int|stdClass $context
     * @param array $options
     */
    public function __construct($repositoryid, $context = SYSCONTEXTID, $options = array()) {
        parent::__construct($repositoryid, $context, $options);
        // Issuer from repository instance config.
        $issuerid = $this->get_option('issuerid');
        $this->oauth2_issuer = oauth2_api::get_issuer($issuerid);

        if (!$this->oauth2_issuer) {
            $this->disabled = true;
            return;
        } else if (!$this->oauth2_issuer->get('enabled')) {
            // In case the Issuer is not enabled, the repository is disabled.
            $this->disabled = true;
            return;
        } else if (!issuer_management::is_valid_issuer($this->oauth2_issuer)) {
            // Check if necessary endpoints are present.
            $this->disabled = true;
            return;
        }
    }

    /**
     * @throws coding_exception
     * @throws \Exception
     */
    private function getOcisClient(): Ocis {
        $access_token = $this->get_user_oauth_client()->get_accesstoken();

        if ($this->ocis === null) {
            $webfinger_url = issuer_management::get_webfinger_url($this->oauth2_issuer);
            if ($webfinger_url) {
                $this->ocis = new Ocis($webfinger_url, $access_token->token, ['webfinger' => true]);
            } else {
                $base_url = $this->oauth2_issuer->get('baseurl');
                $this->ocis = new Ocis($base_url, $access_token->token);
            }


        } else {
            //update the token for the ocis client, just in case it changed
            $this->ocis->setAccessToken($access_token->token);
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

        /**
         * @type ?Drive $personalDrive
         */
        $personalDrive = null;
        foreach ($drives as $drive) {
            /**
             * @type Drive $drive
             */
            if ($drive->getType() === DriveType::PERSONAL) {
                $personalDrive = $drive;
                break;
            }
        }
        if ($personalDrive === null) {
            throw new Exception(get_string('no_personal_drive_found', 'repository_ocis'));
        }
        $resources = $personalDrive->listResources($path);

        $list = [];
        /**
         * @type OcisResource $resource
         */
        foreach ($resources as $resource) {
            $last_modified_time = new DateTime($resource->getLastModifiedTime());
            $list_item = [
                'title' => $resource->getName(),
                'date' => $last_modified_time->getTimestamp(),
                'size' => $resource->getSize(),
                'source' => $resource->getId()
            ];
            if ($resource->getType() === 'folder') {
                $list_item['children'] = [];
                $list_item['path'] = $path . "/" . $resource->getName();
                $list_item['thumbnail'] = $OUTPUT->image_url(file_folder_icon(90))->out(false);

                // for sorting, `0` to make sure folders are on top
                // then the name in uppercase to sort everything alphabetically with ksort
                $list["0" . strtoupper($resource->getName())] = $list_item;
            } else {
                $list_item['thumbnail'] = $OUTPUT->image_url(
                    file_extension_icon($resource->getName(), 90)
                )->out(false);

                // for sorting, `1` to make sure files are listed after folders
                $list["1" . strtoupper($resource->getName())] = $list_item;

            }
        }

        $breadcrumb_path = [
            [
                'name' => $this->get_meta()->name,
                'path' => '/',
            ]
        ];
        if ($path !== '/') {
            $chunks = explode('/', trim($path, '/'));
            $parent = '/';
            // Every sub-path to the last part of the current path is a parent path.
            foreach ($chunks as $chunk) {
                $subpath = $parent . $chunk . '/';
                $breadcrumb_path[] = [
                    'name' => urldecode($chunk),
                    'path' => $subpath
                ];
                // Prepare next iteration.
                $parent = $subpath;
            }
        }
        ksort($list);
        return [
            //this will be used to build navigation bar
            'dynload' => true,
            'nosearch' => true,
            'path' => $breadcrumb_path,
            'manage' => $personalDrive->getWebUrl(),
            'list' => $list
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
            $mform->addElement('static', null, '',  get_string('nopermissions', 'error', get_string('configplugin',
                'repository_ocis')));
            return false;
        }

        // Load configured issuers.
        $issuers = core\oauth2\api::get_all_issuers();
        $types = array();

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
            $mform->addElement('static', null, '', get_string('right_issuers', 'repository_ocis',
                implode(', ', $validissuers)));
        }
    }

    /**
     * Get a cached user authenticated oauth client.
     *
     * @param bool|moodle_url $overrideurl Use this url instead of the repo callback.
     * @return oauth2_client
     */
    protected function get_user_oauth_client($overrideurl = false) {
        if ($this->oauth2_client) {
            return $this->oauth2_client;
        }
        if ($overrideurl) {
            $returnurl = $overrideurl;
        } else {
            $returnurl = new moodle_url('/repository/repository_callback.php');
            $returnurl->param('callback', 'yes');
            $returnurl->param('repo_id', $this->id);
            $returnurl->param('sesskey', sesskey());
        }
        $this->oauth2_client = oauth2_api::get_user_oauth_client($this->oauth2_issuer, $returnurl, '', true);
        return $this->oauth2_client;
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
            $ret = array();
            $btn = new \stdClass();
            $btn->type = 'popup';
            $btn->url = $loginurl->out(false);
            $ret['login'] = array($btn);
            return $ret;
        } else {
            echo html_writer::link($loginurl, get_string('login', 'repository'),
                array('target' => '_blank',  'rel' => 'noopener noreferrer'));
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
            'defaultreturntype', 'supportedreturntypes'];
    }

    public function get_file($fileId, $filename = ''): array
    {
        $ocis = $this->getOcisClient();

        $local_path = $this->prepare_file($fileId);
        $stream = $ocis->getFileStreamById($fileId);
        file_put_contents($local_path, $stream);
        return ['path' => $local_path, 'url' => $fileId];
    }
}
