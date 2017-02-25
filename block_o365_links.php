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
 * Outputs the navigation tree.
 *
 * @since     2.0
 * @package   block_o354_links
 * @copyright 2015 Boulbaba Othmani (boulbaba@edunao.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_o365_links extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_o365_links');
    }

    /**
     * Check if the block have a configuration file.
     * @return boolean True if the block have a configuration file, false otherwise.
     */
    public function has_config() {
        return true;
    }

    public function get_content() {
        global $OUTPUT, $CFG, $DB, $PAGE;

        if ($this->content !== null) {
          return $this->content;
        }

        $lang = current_language();
        $lang = '-'.$lang;

        if (!file_exists($CFG->dirroot.'/blocks/o365_links/pix/word'.$lang.'.png')) {
            $lang = '-en';
        }

        $config = get_config('local_o365');
        if (!$config) {
            $config = new StdClass;
            $config->tenant = '';
        }
        $blockconfig = get_config('block_o365_links');

        $links = array(
            array('url' => 'https://office.live.com/start/Word.aspx',
                  'alt' => get_string('word', 'block_o365_links'),
                  'icon' => $OUTPUT->pix_url('word'.$lang, 'block_o365_links')),
            array('url' => 'https://office.live.com/start/PowerPoint.aspx',
                  'alt' => get_string('powerpoint', 'block_o365_links'),
                  'icon' => $OUTPUT->pix_url('powerpoint'.$lang, 'block_o365_links')),
            array('url' => 'https://office.live.com/start/Excel.aspx',
                  'alt' => get_string('excel', 'block_o365_links'),
                  'icon' => $OUTPUT->pix_url('excel'.$lang, 'block_o365_links')),

            array('url' => 'https://www.onenote.com/notebooks',
                  'alt' => get_string('onenote', 'block_o365_links'),
                  'icon' => $OUTPUT->pix_url('onenote'.$lang, 'block_o365_links')),
        );

        if (!empty($blockconfig->showoutlookservices)) {
            $links[] = array('url' => 'https://outlook.office365.com/owa/?modurl=0',
                  'alt' => get_string('outlook', 'block_o365_links'),
                  'icon' => $OUTPUT->pix_url('outlook'.$lang, 'block_o365_links'));
            $links[] = array('url' => 'https://outlook.office365.com/owa/?modurl=1',
                  'alt' => get_string('calendar', 'block_o365_links'),
                  'icon' => $OUTPUT->pix_url('calendar'.$lang, 'block_o365_links'));
            $links[] = array('url' => 'https://outlook.office365.com/owa/?modurl=2',
                  'alt' => get_string('contacts', 'block_o365_links'),
                  'icon' => $OUTPUT->pix_url('people'.$lang, 'block_o365_links'));
            $links[] = array('url' => 'https://outlook.office365.com/owa/?modurl=3',
                  'alt' => get_string('tasks', 'block_o365_links'),
                  'icon' => $OUTPUT->pix_url('tasks'.$lang, 'block_o365_links'));
        }

        $links[] = array('url' => 'https://'.@$config->odburl,
              'alt' => get_string('onedrive', 'block_o365_links'),
              'icon' => $OUTPUT->pix_url('onedrive'.$lang, 'block_o365_links'));
        if (!empty($blockconfig->showvideoservice)) {
            $links[] = array('url' => 'https://'.$blockconfig->sharepointtenant.'.sharepoint.com/portals/hub/_layouts/15/PointPublishing.aspx?app=video&p=h',
                  'alt' => get_string('video', 'block_o365_links'),
                  'icon' => $OUTPUT->pix_url('video'.$lang, 'block_o365_links'));
        }

        $blindframe = '';
        if ($blockconfig->activateblindsession) {
            $o365config = get_config('local_o365');
            if (!empty($o365config->sharepointlink)) {
                $coursespsite = $DB->get_record('local_o365_coursespsite', ['courseid' => $PAGE->context->instanceid]);
                if (!empty($coursespsite)) {
                    $spsite = \local_o365\rest\sharepoint::get_resource();
                    if (!empty($spsite)) {
                        $spurl = $spsite.'/'.$coursespsite->siteurl;
                        $blindframe .= '<iframe style="display:none;width:0px;height:0px" src="'.$spurl.'"></iframe>';
                        /*
                        $yammerurl = 'https://www.yammer.com';
                        $blindframe .= '<iframe style="display:none;width:0px;height:0px" src="'.$yammerurl.'"></iframe>';
                        */
                    }
                }
            }
        }

        $this->content = new StdClass;
        $this->content->text = '<p>';
        foreach ($links as $link) {
            $this->content->text .= '<a href="'.$link['url'].'" target="_blank"><img alt="'.$link['alt'].'" src="'.$link['icon'].'" /></a>';
        }
        $this->content->text .= '</p>';
        $this->content->text .= $blindframe;

        return $this->content;
    }
}