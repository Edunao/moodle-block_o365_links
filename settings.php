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
 * o365_links block settings
 *
 * @package    block_o365_links
 * @copyright  2015 Boubalaba Othmani (boulbaba@edunao.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_o365_links/showoutlookservices', new lang_string('showoutlookservices', 'block_o365_links'),
        new lang_string('showoutlookservicesdesc', 'block_o365_links'), 1));
    $settings->add(new admin_setting_configcheckbox('block_o365_links/showvideoservice', new lang_string('showvideoservice', 'block_o365_links'),
        new lang_string('showvideoservicedesc', 'block_o365_links'), 1));
    $settings->add(new admin_setting_configtext('block_o365_links/sharepointtenant', new lang_string('sharepointtenant', 'block_o365_links'),
        new lang_string('sharepointtenantdesc', 'block_o365_links'), ''));
    $settings->add(new admin_setting_configcheckbox('block_o365_links/activateblindsession', new lang_string('activateblindsession', 'block_o365_links'),
        new lang_string('activateblindsessiondesc', 'block_o365_links'), 1));
}
