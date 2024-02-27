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


unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = getenv('MOODLE_DBTYPE') ?: 'pgsql';
$CFG->dblibrary = 'native';
$CFG->dbhost    = getenv('MOODLE_DBHOST') ?: 'localhost';
$CFG->dbname    = getenv('MOODLE_DBNAME') ?: 'moodle';
$CFG->dbuser    = getenv('MOODLE_DBUSER') ?: 'moodle';
$CFG->dbpass    = getenv('MOODLE_DBPASS') ?: 'moodle';
$CFG->prefix    = 'm_';
$CFG->wwwroot   = getenv('MOODLE_WWWROOT') ?: 'https://127.0.0.1/moodle';
$CFG->dataroot  = getenv('MOODLE_DATAROOT') ?: '/var/www/moodledata';
$CFG->directorypermissions = 02777;
$CFG->admin = 'admin';
$CFG->behat_faildump_path = getenv('MOODLE_DOCKER_BEHAT_FAILDUMP') ?: '/var/www/behatfaildumps';
$CFG->behat_wwwroot = getenv('BEHAT_WWWROOT') ?: 'https://localhost/moodle';
$CFG->behat_prefix = 'bht_';
$CFG->behat_dataroot = getenv('BEHAT_DATAROOT') ?: '/var/www/behatdata';
$seleniumhost = getenv('SELENIUM_HOST') ?: 'localhost';
$seleniumport = getenv('SELENIUM_PORT') ?: '4444';
$CFG->behat_profiles = [
    'default' => [
        'browser' => getenv('BROWSER') ?: 'chrome',
        'wd_host' => "http://$seleniumhost:$seleniumport/wd/hub",
        'capabilities' => [
            'acceptSslCerts' => true,
            'extra_capabilities' => [
                'chromeOptions' => [
                    'args' => [
                        '--ignore-certificate-errors',
                        "--headless",
                    ],
                ],
            ],
        ],
    ],
];
require_once(__DIR__ . '/lib/setup.php');
