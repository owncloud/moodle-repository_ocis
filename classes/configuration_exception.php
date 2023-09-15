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
 * Exception for when client configuration data is missing.
 *
 * @package    repository_ocis
 * @copyright  2017 Project seminar (Learnweb, University of Münster)
 * @copyright  2023 ownCloud GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace repository_ocis;

defined('MOODLE_INTERNAL') || die();

/**
 * Exception for when client configuration data is missing.
 *
 * @package    repository_ocis
 * @copyright  2017 Project seminar (Learnweb, University of Münster)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class configuration_exception extends \moodle_exception {

    /**
     * This exception is used when the configuration of the plugin can not be processed or database entries are
     * missing.
     * @param string $hint optional param for additional information of the problem
     * @param string $debuginfo detailed information how to fix problem
     */
    public function __construct($hint = '', $debuginfo = null) {
        parent::__construct('configuration_exception', 'repository_ocis', '', $hint, $debuginfo);
    }
}
