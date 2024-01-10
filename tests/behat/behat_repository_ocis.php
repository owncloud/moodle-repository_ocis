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

// NOTE: no MOODLE_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__ . '/../../../../lib/behat/core_behat_file_helper.php');

require_once(__DIR__ . '/../../vendor/autoload.php');

use Sabre\DAV\Client,
    Behat\Behat\Hook\Scope\BeforeScenarioScope,
    Behat\Behat\Hook\Scope\AfterScenarioScope;

/**
 * Steps definitions related to repository_ocis.
 */
class behat_repository_ocis extends behat_base {
    private Client $client;
    public function __construct() {
        $settings = [
            'baseUri' => getenv('MOODLE_OCIS_URL'),
            'userName' => 'admin',
            'password' => 'admin',
        ];
        $this->client = new Client($settings);
    }

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope The Behat Scope
     */
    public function set_default_editor_flag(BeforeScenarioScope $scope): void {
        $response = $this->client->request('PUT', "/dav/files/admin/new.txt");
        if (!in_array($response['statusCode'], [201, 204])) {
            throw new Exception("Error creating resource in ocis " . var_dump($response['statusCode']));
        }
    }

    /**
     * @param AfterScenarioScope $scope scope passed by event fired after scenario.
     * @AfterScenario
     */
    public function reset_webdriver_between_scenarios(AfterScenarioScope $scope) {
        $response = $this->client->request('DELETE', "/dav/files/admin/new.txt");
        if ($response['statusCode'] !== 204) {
            throw new Exception("Error deleting resource in ocis " . var_dump($response['statusCode']));
        }
    }

    /**
     * @Given I click on Allow Button
     */
    public function iclickallowbuttonintheconcentpage() {
        $node = $this->get_selected_node('xpath_element', "//span[text()='Allow']");
        $this->ensure_node_is_visible($node);
        $node->click();
        $this->getSession()->switchToWindow(null);
    }
}
