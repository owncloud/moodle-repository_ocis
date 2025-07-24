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
require_once(__DIR__ . '/graph_helper.php');


use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Gherkin\Node\TableNode;
use behat\graph_helper;

/**
 * Steps definitions related to repository_ocis.
 */
class behat_repository_ocis extends behat_base {
    /**
     * A helper class to make API requests
     * @var graph_helper $graphhelper
     */
    private graph_helper $graphhelper;
    /**
     * Stores all resources created by tests
     * @var array $createdfiles
     */
    public array $createdfiles;
    /**
     * Stores all spaces created by tests
     * @var array $createdspaces
     */
    public array $createdspaces;
    /**
     * Stores all users created by tests
     * @var graph_helper $createdusers
     */
    private array $createdusers;

    /**
     * Constructor
     */
    public function __construct() {
        $this->createdfiles = [];
        $this->createdspaces = [];
        $this->createdusers = [];
        $this->graphhelper = new graph_helper();
    }

    /**
     * Delete all created files in oCIS
     * @param AfterScenarioScope $scope scope passed by event fired after scenario.
     * @AfterScenario
     */
    public function delete_file_in_ocis(AfterScenarioScope $scope) {
        foreach ($this->createdfiles as $file) {
            $this->delete_file_in_personal_space($file['user'], $file['file']);
        }
    }

    /**
     * Delete all created project spaces
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
     * Delete all users created by tests in oCIS
     * @param AfterScenarioScope $scope scope passed by event fired after scenario.
     * @AfterScenario
     * @throws Exception
     * @return void
     */
    public function delete_all_created_users(AfterScenarioScope $scope): void {
        $createdusers = $this->get_all_created_users();
        foreach ($createdusers as $user) {
            $this->delete_created_user($user["user_id"]);
        }
    }

    /**
     * Adds a space to the 'created spaces storage'
     * @param mixed $response
     * @return void
     */
    private function add_to_created_spaces($response): void {
        $this->createdspaces[] = [
            "name" => $response->name,
            "spaceid" => $response->id,
        ];
    }

    /**
     * Add users to created user list
     * @param mixed $response
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
     * Get all created users
     * @return array
     */
    private function get_all_created_users(): array {
        return $this->createdusers;
    }

    /**
     * Get all created spaces
     * @return array
     */
    public function get_all_created_project_spaces(): array {
        return $this->createdspaces;
    }

    /**
     * Delete a space
     * @param string $spaceid
     *
     * @return void
     * @throws Exception
     */
    public function delete_space(string $spaceid): void {
        $client = $this->graphhelper->get_admin_client();
        $header = ["Purge" => "T"];
        $disabledrive = $client->request('DELETE', "/graph/v1.0/drives/$spaceid");
        $deletedrive = $client->request('DELETE', "/graph/v1.0/drives/$spaceid", null, $header);
        if ($disabledrive['statusCode'] && $deletedrive['statusCode'] !== 204) {
            throw new Exception('Error deleting drive');
        }
    }
    /**
     * Delete a file in the personal space
     *
     * @param string $user
     * @param string $file
     * @return void
     */
    private function delete_file_in_personal_space(string $user, string $file) {
        $client = $this->graphhelper->get_client($user);
        $response = $client->request('DELETE', "/dav/files/$user/$file");
        if ($response['statusCode'] !== 204) {
            throw new Exception("Error deleting resource in ocis " . var_dump($response['statusCode']));
        }
    }

    /**
     * Delete a users
     *
     * @param string $userid
     * @return void
     */
    private function delete_created_user(string $userid) {
        $client = $this->graphhelper->get_admin_client();
        $response = $client->request('DELETE', "/graph/v1.0/users/$userid");
        if ($response['statusCode'] !== 204) {
            throw new Exception("Error deleting user ");
        }
    }

    /**
     * Login to oCIS
     * @Given I log in to ocis as :user
     * @param string $user
     */
    public function i_log_in_to_ocis(string $user) {
        $this->execute('behat_forms::set_field_node_value', [
            $this->find('xpath', "//*[@id='oc-login-username']"), $this->graphhelper->get_actual_username($user),
        ]);

        $this->execute('behat_forms::set_field_node_value', [
            $this->find('xpath', "//*[@id='oc-login-password']"), $this->graphhelper->get_password_for_user($user),
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
     * Upload a file to oCIS
     * @Given /^user "([^"]*)" (?:uploads|has uploaded) a file inside space "([^"]*)" with content "([^"]*)" to "([^"]*)"$/
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
            $this->graphhelper->create_file_in_personal_space($user, $file, $content);
            $this->createdfiles[] = ["file" => $file, "user" => $user];
        } else {
            $this->graphhelper->create_resource_in_project_space($space, $file, $content);
        }
    }

    /**
     * Change visibility of a drives
     * @When I change the visibility of :drive drive to :visiblity
     *
     * @param string $drive
     * @param string $visibility
     * @return void
     */
    public function i_change_visibility_of_space_to(string $drive, string $visibility): void {
        $selector = $this->get_visibility_setting_selector($drive);
        $this->get_selected_node(
            "xpath_element",
            "$selector/option[text()='$visibility']"
        )->click();
        $this->get_selected_node("button", "Save")->click();
    }

    /**
     * Get the visibility setting selector
     * @param string $drive
     *
     * @return string
     */
    public function get_visibility_setting_selector(string $drive): string {
        if (strtolower($drive) === "personal") {
            return "//*[@id='id_show_personal_drive']";
        } else if (strtolower($drive) === "shares") {
            return "//*[@id='id_show_shares']";
        } else {
            return "//*[@id='id_show_project_drives']";
        }
    }

    /**
     * Create a project space
     * @Given /^"([^"]*)" (?:creates|has created) the project space "([^"]*)"$/
     *
     * @param string $user
     * @param string $space
     *
     * @return void
     * @throws JsonException
     */
    public function user_has_created_the_project_space(string $user, string $space) {
        $client = $this->graphhelper->get_client($user);
        $body = json_encode(["name" => $space], JSON_THROW_ON_ERROR);
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
     * Refresh the file picker
     * @Given I refresh the file-picker
     *
     * @return void
     */
    public function i_refresh_the_file_picker(): void {
        $refreshbutton = $this->get_selected_node('css_element', '.fp-tb-refresh.enabled');
        $refreshbutton->click();
    }

    /**
     * Create a user in oCIS
     * @Given user :user has been created with default attributes
     *
     * @param string $user
     *
     * @throws Exception
     */
    public function user_has_been_created_with_default_attributes(string $user) {
        $username = $this->graphhelper->get_actual_username($user);
        $email = \str_replace(["@", " "], "", $username) . '@owncloud.com';
        $payload['onPremisesSamAccountName'] = $username;
        $payload['passwordProfile'] = ['password' => $this->graphhelper->get_password_for_user($username)];
        $payload['displayName'] = $username;
        $payload['mail'] = $email;
        $payload['accountEnabled'] = true;

        $client = $this->graphhelper->get_admin_client();
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
     * Send a share invitation
     * @Given /^user "([^"]*)" (?:sends|has sent) the following share invitation:$/
     * @param string $user
     * @param TableNode $table
     *
     * @throws Exception
     */
    public function user_has_sent_the_following_share_invitation(string $user, TableNode $table) {
        $rows = $table->getRowsHash();
        $response = $this->graphhelper->send_share_invitation(
            $user,
            $rows['shareType'],
            $rows['sharee'],
            $rows['space'],
            $rows['resource']
        );
        if ($response['statusCode'] !== 200) {
            throw new Exception("Error creating share "
                . json_decode($response['body'], true)['error']['message']);
        }
    }

    /**
     * Check if refreshing file picker shows the latest changes of oCIS server
     * @Then I should see :arg1 after refreshing the file-picker
     *
     * @param string $text
     * @return void
     */
    public function i_should_see_after_refreshing_the_file_picker(string $text) {
        $refreshbutton = $this->get_selected_node('css_element', '.fp-tb-refresh.enabled');
        $refreshbutton->click();
        $this->execute('behat_general::assert_page_contains_text', [$text]);
    }

    /**
     * Step definition for disabling sync of share
     * @When user :user disables sync of share :share
     *
     * @param string $user
     *
     * @throws Exception
     */
    public function user_disables_sync_of_share(string $user) {
        $response = $this->graphhelper->disable_share_sync($user);
        if ((!in_array($response['statusCode'], [200, 204]))) {
            throw new Exception("Error disabling sync of share " . var_dump($response['statusCode']));
        }
    }

    /**
     * Step definition for enabling sync of share
     * @When user :user enables sync of share :share offered by :offeredBy from :space space
     *
     * @param string $user
     * @param string $share
     * @param string $offeredby
     * @param string $space
     *
     * @throws Exception
     */
    public function user_enables_sync_of_share(string $user, string $share, string $offeredby, string $space) {
        $response = $this->graphhelper->enable_share_sync($user, $share, $offeredby, $space);
        if ($response['statusCode'] !== 201) {
            throw new Exception("Error enabling sync of share");
        }
    }
}
