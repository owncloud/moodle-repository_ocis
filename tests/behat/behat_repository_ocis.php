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
// ownCloud Infinite Scale for moodle Repository is built with the contributions of:
// - Staatsinstitut für Schulqualität und Bildungsforschung
// - JankariTech
// - ownCloud - a Kiteworks company.

/**
 * Steps definitions related to repository_ocis.
 *
 * @package    repository_ocis
 * @copyright  2017 Project seminar (Learnweb, University of Münster)
 * @copyright  2023 ownCloud GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(__DIR__ . '/../../../../lib/behat/core_behat_file_helper.php');

require_once(__DIR__ . '/../../vendor/autoload.php');

use Sabre\DAV\Client,
    Behat\Behat\Hook\Scope\AfterScenarioScope;

/**
 * Steps definitions related to repository_ocis.
 */
class behat_repository_ocis extends behat_base {
    public array $createdfiles;
    public array $createdspaces;

    public function __construct() {
        $this->createdFiles = [];
        $this->createdSpaces = [];
    }

    /**
     * @param AfterScenarioScope $scope scope passed by event fired after scenario.
     * @AfterScenario
     */
    public function delete_file_in_ocis(AfterScenarioScope $scope) {
        foreach ($this->createdFiles as $file) {
            $this->delete_file_in_personal_space($file['user'], $file['file']);
        }
    }

    /**
     * @param AfterScenarioScope $scope scope passed by event fired after scenario.
     * @AfterScenario
     */
    public function delete_all_project_space(AfterScenarioScope $scope) {
        $createdspace = $this->get_all_created_project_space();
        foreach ($createdspace as $space) {
            $this->delete_space();
        }
    }

    private function get_client($user): Client {
        $username = $this->get_actual_username($user);
        $password = $this->get_password_for_user($user);
        $settings = [
            'baseUri' => getenv('MOODLE_OCIS_URL'),
            'userName' => $username,
            'password' => $password,
        ];
        return new Client($settings);
    }

    private function get_admin_client(): Client {
        $settings = [
            'baseUri' => getenv('MOODLE_OCIS_URL') ? getenv('MOODLE_OCIS_URL') : 'https://host.docker.internal:9200',
            'userName' => getenv('OCIS_ADMIN_USERNAME') ? getenv('OCIS_ADMIN_USERNAME') : 'admin',
            'password' => getenv('OCIS_ADMIN_PASSWORD') ? getenv('OCIS_ADMIN_PASSWORD') : 'admin',
        ];
        return new Client($settings);
    }

    public function get_space_id_by_space($space): string {
        foreach ($this->get_all_created_project_space() as $createdspace) {
            if ($createdspace["name"] === $space) {
                return $createdspace["spaceId"];
            }
        }
    }

    private function add_to_created_space($response) {
        $this->createdSpaces[] = [
            "name" => $response->name,
            "spaceId" => $response->id,
        ];
    }

    public function get_all_created_project_space(): array {
        return $this->createdSpaces;
    }

    private function get_actual_username(string $username): string {
        if (strtolower($username) === 'admin') {
            return getenv('OCIS_ADMIN_USERNAME') ? getenv('OCIS_ADMIN_USERNAME') : "admin";
        } else {
            return $username;
        }
    }

    private function get_password_for_user(string $username): string {
        if (strtolower($username) === 'admin') {
            return getenv('OCIS_ADMIN_PASSWORD') ? getenv('OCIS_ADMIN_PASSWORD') : "admin";
        } else {
            return "";
        }
    }

    private function create_file_in_personal_space($user, $file) {
        $client = $this->get_client($user);
        $response = $client->request('PUT', "/dav/files/$user/$file");
        if (!in_array($response['statusCode'], [201, 204])) {
            throw new Exception("Error creating resource in ocis " . var_dump($response['statusCode']));
        }
        $this->createdFiles[] = ["file" => $file, "user" => $user];
    }

    /**
     * @param string $user
     * @param string $space
     *
     * @return void
     * @throws JsonException
     */
    private function create_project_space(string $user, string $space): void {
        $client = $this->get_client($user);
        $body = json_encode(["Name" => $space], JSON_THROW_ON_ERROR);
        $response = $client->request(
            'POST',
            "/graph/v1.0/drives",
            $body,
        );
        if (!isset($response['statusCode']) && $response['statusCode'] !== 201) {
            throw new Exception("Error creating space in ocis " . var_dump($response['statusCode']));
        }
        $responsebody = json_decode($response["body"]);
        $this->add_to_created_space($responsebody);
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function delete_space() {
        $client = $this->get_admin_client();
        $spaceid = $this->get_all_created_project_space()[0]["spaceId"];
        $header = ["Purge" => "T"];
        $disabledrive = $client->request('DELETE', "/graph/v1.0/drives/$spaceid");
        $deletedrive = $client->request('DELETE', "/graph/v1.0/drives/$spaceid", null, $header);
        if ($disabledrive['statusCode'] && $deletedrive['statusCode'] !== 204) {
            throw new Exception('Error deleting drive');
        }
    }

    private function delete_file_in_personal_space($user, $file) {
        $client = $this->get_client($user);
        $response = $client->request('DELETE', "/dav/files/$user/$file");
        if ($response['statusCode'] !== 204) {
            throw new Exception("Error deleting resource in ocis " . var_dump($response['statusCode']));
        }
    }

    public function create_resource_in_project_space($space, $resource, $body): array {
        $client = $this->get_admin_client();
        $spaceid = $this->get_space_id_by_space($space);
        $response = $client->request('PUT', "dav/spaces/$spaceid/$resource", $body);
        return $response;
    }

    /**
     * @Given I log in to ocis as :user
     */
    public function i_log_in_to_ocis($user) {
        $this->execute('behat_forms::set_field_node_value', [
            $this->find('xpath', "//*[@id='oc-login-username']"), $this->get_actual_username($user),
        ]);

        $this->execute('behat_forms::set_field_node_value', [
            $this->find('xpath', "//*[@id='oc-login-password']"), $this->get_password_for_user($user),
        ]);

        $loginbutton = $this->get_selected_node("button", "Log in");
        $this->ensure_node_is_visible($loginbutton);
        $loginbutton->click();

        $allowbutton = $this->get_selected_node('xpath_element', "//span[text()='Allow']");
        $this->ensure_node_is_visible($allowbutton);
        $allowbutton->click();
        $this->getSession()->switchToWindow(null);
    }

    /**
     * @Given :user uploads file with content :content to :file in :space space
     *
     * @param string $user
     * @param string $content
     * @param string $file
     * @param string $space
     */
    public function user_creates_a_file($user, $content, $file, $space) {
        if (strtolower($space) === "personal") {
            $this->create_file_in_personal_space($user, $file);
        } else {
            $this->create_resource_in_project_space($space, $file, $content);
        }
    }

    /**
     * @Given :user creates a project space :space
     *
     * @param string $user
     * @param string $space
     *
     * @return void
     */
    public function user_creates_a_project_space(string $user, string $space) {
        $this->create_project_space($user, $space);
    }

    /**
     * @Given I click on Refresh button
     */
    public function i_click_on_refresh_button(): void {
        $refreshbutton = $this->get_selected_node('css_element', '.fp-tb-refresh.enabled');
        $refreshbutton->click();
    }
}
