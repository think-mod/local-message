<?php

/**
 * @package local_message
 * @author Will Nahmens
 * @license http://www.gnu.org/copyleft/gpl.html
 * @var staClass $plugin
 */

require_once(__DIR__.'/../../config.php');

global $DB;

$PAGE->set_url(new moodle_url('/local/message/manage_message.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Manage Messages');

$messages = $DB->get_records('local_message');

// require valid moodle login.  Will redirect to login page if not logged in.
require_login();

echo $OUTPUT->header();

$templatecontext = (object)[
    'messages' => array_values($messages),
    'editurl' => new moodle_url('/local/message/edit.php'),
];

echo $OUTPUT->render_from_template('local_message/manage', $templatecontext);

echo $OUTPUT->footer();