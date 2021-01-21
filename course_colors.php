<?php

/**
 * @package local_message
 * @author Will Nahmens
 * @license http://www.gnu.org/copyleft/gpl.html
 * @var staClass $plugin
 */

require_once(__DIR__.'/../../config.php');
require_once($CFG->dirroot . '/local/message/classes/form/edit.php');

global $DB, $USER;

$PAGE->set_url(new moodle_url('/local/message/course_color.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Course Color Settings');

// display form
$mform = new edit();


//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    // go back to manage page
    redirect($CFG->wwwroot . '/local/message/manage_message.php', 'You cancelled the message form');
} else if ($fromform = $mform->get_data()) {
    //insert the data into the database

    $recordtoinsert = new stdClass();
    $recordtoinsert->messagetext = $fromform->messagetext;
    $recordtoinsert->messagetype = $fromform->messagetype;
    $recordtoinsert->userid = $USER->id;

    $DB->insert_record('local_message', $recordtoinsert);
    
    redirect($CFG->wwwroot . '/local/message/manage_message.php', 'You created a message with text: '. $fromform->messagetext);

}

echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();