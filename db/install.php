<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Installation file for the cloudstudio repository.
 *
 * @package   repository_cloudstudio
 * @copyright 2024 EadTech {@link https://www.eadtech.com.br}
 * @author    2024 Eduardo Kraus {@link https://www.eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Repository cloudstudio install.
 *
 * @return bool Return true.
 */
function xmldb_repository_cloudstudio_install() {
    global $DB;

    $repository = (object)[
        "type" => "cloudstudio",
        "visible" => 1,
        "sortorder" => 2,
    ];
    $repository->id = $DB->insert_record("repository", $repository);

    $repository_instances = (object)[
        "name" => "",
        "typeid" => $repository->id,
        "userid" => 0,
        "contextid" => 1,
        "username" => null,
        "password" => null,
        "timecreated" => time(),
        "timemodified" => time(),
        "readonly" => 0,
    ];
    $repository_instances->id = $DB->insert_record("repository_instances", $repository_instances);

    return true;
}
