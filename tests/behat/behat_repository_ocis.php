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

use Behat\Behat\Hook\Scope\BeforeScenarioScope;

use Behat\Gherkin\Node\TableNode;

require('graph_helper.php');

/**
 * Steps definitions related to repository_ocis.
 */
class behat_repository_ocis extends behat_base {
    private graph_helper $graphhelper;
    public array $createdfiles;
    public array $createdspaces;
    private array $createdusers;

    public function __construct() {
        $this->createdfiles = [];
        $this->createdspaces = [];
        $this->createdusers = [];
        $this->graph_helper = new graph_helper();
    }

    /**
     * @param AfterScenarioScope $scope scope passed by event fired after scenario.
     * @AfterScenario
     */
    public function delete_file_in_ocis(AfterScenarioScope $scope) {
        foreach ($this->createdfiles as $file) {
            $this->delete_file_in_personal_space($file['user'], $file['file']);
        }
    }

    /**
     * @param AfterScenarioScope $scope scope passed by event fired after scenario.
     * @AfterScenario
     *
     * @throws Exception
     */
    public function delete_all_project_spaces(AfterScenarioScope $scope): void {
        $createdspaces = $this->get_all_created_project_spaces();
        foreach ($createdspaces as $space) {
            $this->delete_space($space["spaceid"]);
        }
    }

    /**
     * @param AfterScenarioScope $scope scope passed by event fired after scenario.
     * @AfterScenario
     * @throws Exception
     */
    public function delete_all_created_users(AfterScenarioScope $scope): void {
        $createdusers = $this->get_all_created_users();
        foreach ($createdusers as $user) {
            $this->delete_created_user($user["user_id"]);
        }
    }

    /**
     *
     * @param $response
     * @return void
     */
    private function add_to_created_spaces($response): void {
        $this->createdspaces[] = [
            "name" => $response->name,
            "spaceid" => $response->id,
        ];
    }

    /**
     * @param $response
     *
     * @return void
     */
    private function add_user_to_created_users_list($response): void {
        $this->createdusers[] = [
            "user" => $response->displayName,
            "user_id" => $response->id,
        ];
    }

    /**
     * @return array
     */
    private function get_all_created_users(): array {
        return $this->createdusers;
    }

    /**
     * @return array
     */
    public function get_all_created_project_spaces(): array {
        return $this->createdspaces;
    }

    /**
     * @param $spaceid
     *
     * @return void
     * @throws Exception
     */
    public function delete_space($spaceid): void {
        $client = $this->graph_helper->get_admin_client();
        $header = ["Purge" => "T"];
        $disabledrive = $client->request('DELETE', "/graph/v1.0/drives/$spaceid");
        $deletedrive = $client->request('DELETE', "/graph/v1.0/drives/$spaceid", null, $header);
        if ($disabledrive['statusCode'] && $deletedrive['statusCode'] !== 204) {
            throw new Exception('Error deleting drive');
        }
    }

    private function delete_file_in_personal_space($user, $file) {
        $client = $this->graph_helper->get_client($user);
        $response = $client->request('DELETE', "/dav/files/$user/$file");
        if ($response['statusCode'] !== 204) {
            throw new Exception("Error deleting resource in ocis " . var_dump($response['statusCode']));
        }
    }

    private function delete_created_user(string $userid) {
        $client = $this->graph_helper->get_admin_client();
        $response = $client->request('DELETE', "/graph/v1.0/users/$userid");
        if ($response['statusCode'] !== 204) {
            throw new Exception("Error deleting user ");
        }
    }

    /**
     * @Given I log in to ocis as :user
     */
    public function i_log_in_to_ocis($user) {
        $this->execute('behat_forms::set_field_node_value', [
            $this->find('xpath', "//*[@id='oc-login-username']"), $this->graph_helper->get_actual_username($user),
        ]);

        $this->execute('behat_forms::set_field_node_value', [
            $this->find('xpath', "//*[@id='oc-login-password']"), $this->graph_helper->get_password_for_user($user),
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
     * @Given user :user has uploaded a file inside space :space with content :content to :file
     *
     * @param string $user
     * @param string $space
     * @param string $content
     * @param string $file
     *
     *
     * @return void
     * @throws Exception
     */
    public function user_has_uploaded_a_file(string $user, string $space, string $content, string $file): void {
        if (strtolower($space) === "personal") {
            $this->graph_helper->create_file_in_personal_space($user, $file, $content);
            $this->createdfiles[] = ["file" => $file, "user" => $user];
        } else {
            $this->graph_helper->create_resource_in_project_space($space, $file, $content);
        }
    }

    /**
     * @Given :user has created the project space :space
     *
     * @param string $user
     * @param string $space
     *
     * @return void
     * @throws JsonException
     */
    public function user_has_created_the_project_space(string $user, string $space) {
        $client = $this->graph_helper->get_client($user);
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
        $this->add_to_created_spaces($responsebody);
    }

    /**
     * @Given I refresh the file-picker
     *
     * @return void
     */
    public function i_refresh_the_file_picker(): void {
        $refreshbutton = $this->get_selected_node('css_element', '.fp-tb-refresh.enabled');
        $refreshbutton->click();
    }

    /**
     * @Given user :user has been created with default attributes
     *
     * @param string $user
     *
     * @throws Exception
     */
    public function user_has_been_created_with_default_attributes(string $user) {
        $username = $this->graph_helper->get_actual_username($user);
        $email = \str_replace(["@", " "], "", $username) . '@owncloud.com';
        $payload['onPremisesSamAccountName'] = $username;
        $payload['passwordProfile'] = ['password' => $this->graph_helper->get_password_for_user($username)];
        $payload['displayName'] = $username;
        $payload['mail'] = $email;
        $payload['accountEnabled'] = true;

        $client = $this->graph_helper->get_admin_client();
        $response = $client->request(
            'POST',
            '/graph/v1.0/users',
            json_encode($payload)
        );
        if ($response['statusCode'] !== 201) {
            throw new Exception("Error creating user '$$user'."
                . json_decode($response['body'], true)['error']['message']);
        }
        $responsebody = json_decode($response["body"]);
        $this->add_user_to_created_users_list($responsebody);
    }

    /**
     * @Given user :arg1 has sent the following share invitation:
     */
    public function user_has_sent_the_following_share_invitation(string $user, TableNode $table) {
        $response = $this->graph_helper->send_share_invitation(
            $user,
            $table
        );
        // phpcs:ignore
        print_object($response);
        if ($response['statusCode'] !== 200) {
            throw new Exception("Error creating share "
                . json_decode($response['body'], true)['error']['message']);
        }
    }
}
