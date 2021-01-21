<?php
// This file is part of Moodle - https://moodle.org/
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
 * Adds admin settings for the plugin.
 *
 * @package     local_message
 * @category    admin
 * @copyright   2020 Your Name <email@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
defined('MOODLE_INTERNAL') || die();
 
if ($hassiteconfig) {
    $ADMIN->add('localplugins', new admin_category('local_message_settings', 'Set course color'));
    $settingspage = new admin_settingpage('setcoursecolors', 'Set course colors');
 
    if ($ADMIN->fulltree) {
        // course list
        global $DB;

        $courses = $DB->get_records('course');

        foreach(array_slice($courses, 1) as $course) { // first course will be the general site
            $camelCaseName = str_replace(' ', '', ucwords(str_replace('-', '', $course->fullname)));
            $name = 'thinkmodular_settings/courseColor'.$course->id;
            $title = $course->fullname.' Color Settings';
            $description = 'Choose a color for this course';
            $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
            $setting->set_updatedcallback('theme_reset_all_caches');
            $settingspage->add($setting);

            /*$camelCaseName = str_replace(' ', '', ucwords(str_replace('-', '', $course->fullname)));
            $name = 'theme_moovechild/courseSVG'.$course->id;
            $title = $course->fullname.' Custom SVG';
            $description = 'My logo here';
            $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
            $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo', 0, $opts);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $settingspage->add($setting);*/
        }

    }
 
    $ADMIN->add('localplugins', $settingspage);
}

$PAGE->requires->js( new moodle_url($CFG->wwwroot . '/local/message/main.js'));

