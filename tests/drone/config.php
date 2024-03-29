<?php
// phpcs:ignoreFile

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
