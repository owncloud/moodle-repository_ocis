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

    public function __construct() {
        $this->createdfiles = [];
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

    /**
     * @Given :user has created a file :file in :space space
     */
    public function user_has_created_a_file($user, $file, $space) {
        if (strtolower($space) === "personal") {
            $this->create_file_in_personal_space($user, $file);
        }
        $this->createdfiles[] = ["file" => $file, "user" => $user];
    }

    private function get_client($user, $password): Client {
        $settings = [
            'baseUri' => getenv('MOODLE_OCIS_URL'),
            'userName' => $user,
            'password' => $password,
        ];
        return new Client($settings);
    }


    private function create_file_in_personal_space($user, $file) {
        $client = $this->get_client($this->get_actual_username($user), $this->get_password_for_user($user));
        $response = $client->request('PUT', "/dav/files/$user/$file");
        if (!in_array($response['statusCode'], [201, 204])) {
            throw new Exception("Error creating resource in ocis " . var_dump($response['statusCode']));
        }
    }

    private function delete_file_in_personal_space($user, $file) {
        $client = $this->get_client($this->get_actual_username($user), $this->get_password_for_user($user));
        $response = $client->request('DELETE', "/dav/files/$user/$file");
        if ($response['statusCode'] !== 204) {
            throw new Exception("Error deleting resource in ocis " . var_dump($response['statusCode']));
        }
    }
}
