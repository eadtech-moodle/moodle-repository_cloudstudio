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
 * Lib class
 *
 * @package   repository_cloudstudio
 * @copyright 2024 EadTech {@link https://www.eadtech.com.br}
 * @author    2024 Eduardo Kraus {@link https://www.eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_cloudstudio\local\util\cloudstudio_api;

defined('MOODLE_INTERNAL') || die();

require_once("{$CFG->dirroot}/repository/lib.php");

/**
 * Repository cloudstudio class
 *
 * @package   repository_cloudstudio
 * @copyright 2018 Eduardo Kraus  {@link http://cloudstudio.com.br}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class repository_cloudstudio extends repository {

    /**
     * Youtube plugin constructor
     *
     * @param int $repositoryid
     * @param object $context
     * @param array $options
     */
    public function __construct($repositoryid, $context = SYSCONTEXTID, $options = array()) {
        parent::__construct($repositoryid, $context, $options);
    }

    /**
     * Get file listing.
     *
     * @param string $encodedpath
     * @param string $page
     *
     * @return array
     */
    public function get_listing($encodedpath = "", $page = "") {
        return $this->search("", 0);
    }

    /**
     * Return search results.
     *
     * @param string $searchtext
     * @param int $page
     *
     * @return array|mixed
     */
    public function search($searchtext, $page = 0) {
        global $SESSION;
        $sessionkeyword = "cloudstudio_" . $this->id;

        if ($page && !$searchtext && isset($SESSION->{$sessionkeyword})) {
            $searchtext = $SESSION->{$sessionkeyword};
        }

        $SESSION->{$sessionkeyword} = $searchtext;

        $url = cloudstudio_api::get_url();

        $ret = [
            "dynload" => true,
            "nologin" => true,
            "page" => (int)$page,
            "norefresh" => false,
            "nosearch" => false,
            "manage" => "https://{$url}/",
        ];
        $ret["list"] = $this->search_videos($searchtext, $page);
        $ret["pages"] = (count($ret["list"]) < 20) ? $ret["page"] : -1;

        return $ret;
    }

    /**
     * Youtube plugin doesn't support global search
     */
    public function global_search() {
        return false;
    }

    /**
     * get type option name function
     *
     * This function is for module settings.
     *
     * @return array
     */
    public static function get_type_option_names() {
        return array_merge(parent::get_type_option_names(), ["key"]);
    }

    /**
     * get type config form function
     *
     * This function is the form of module settings.
     *
     * @param MoodleQuickForm $mform
     * @param string $classname
     */
    public static function type_config_form__($mform, $classname = "repository") {
        parent::type_config_form($mform);
        $key = get_config("repository_cloudstudio", "key");
        $mform->addElement("text", "key", get_string("key", "repository_cloudstudio") . " ("
            . get_string("key_description", "repository_cloudstudio") . ")", array("size" => "40"));
        $mform->setDefault("key", $key);
        $mform->setType("key", PARAM_RAW_TRIMMED);
    }

    /**
     * Private method to search remote videos
     *
     * @param string $searchtext
     * @param int $page
     *
     * @return array
     */
    private function search_videos($searchtext, $page, $pasta = -1) {
        $list = [];
        $error = null;

        $url = cloudstudio_api::get_url();

        $extensions = optional_param_array("accepted_types", [], PARAM_TEXT);
        $arquivos = cloudstudio_api::listing($page, $pasta, $searchtext, $extensions);
        foreach ($arquivos->arquivos as $arquivo) {
            $list[] = [
                "shorttitle" => $arquivo->titulo,
                "title" => "{$arquivo->titulo}.{$arquivo->extension}",
                "thumbnail_title" => $arquivo->titulo,
                "thumbnail" => $arquivo->thumb,
                "icon" => $arquivo->thumb,
                "date" => $arquivo->data,
                "source" => $arquivo->url,
                "license" => "Cloud Studio (https://{$url}/)"
            ];
        }

        return $list;
    }

    /**
     * file types supported by cloudstudio plugin
     *
     * @return array
     */
    public function supported_filetypes() {
        return ["video", "audio", "pdf"];
    }

    /**
     * cloudstudio plugin only return external links
     *
     * @return int
     */
    public function supported_returntypes() {
        return FILE_EXTERNAL;
    }

    /**
     * Is this repository accessing private data?
     *
     * @return bool
     */
    public function contains_private_data() {
        return false;
    }
}
