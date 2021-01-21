<?php

/**
 * @package local_message
 * @author Will Nahmens
 * @license http://www.gnu.org/copyleft/gpl.html
 * @var staClass $plugin
 */


function local_message_before_footer() {

    global $DB, $USER;

    $sql = 'SELECT lm.id, lm.messagetext, lm.messagetype FROM {local_message} lm 
            left outer join {local_message_read} lmr ON lm.id = lmr.messageid
            WHERE lmr.userid <> userid OR lmr.userid IS NULL';

    $params = [
        'userid' => $USER->id,
    ];

    $messages = $DB->get_records_sql($sql, $params);


    foreach($messages as $message) {
        $type = \core\output\notification::NOTIFY_INFO;

        if($message->messagetype === '0') {
            $type=\core\output\notification::NOTIFY_WARNING;
        } elseif($message->messagetype === '1') {
            $type=\core\output\notification::NOTIFY_SUCCESS;
        } elseif($message->messagetype === '2') {
            $type=\core\output\notification::NOTIFY_ERROR;
        }

        \core\notification::add($message->messagetext, $type);

        $readrecord = new stdClass();
        $readrecord->messageid = $message->id;
        $readrecord->userid  = $USER->id;
        $readrecord->timeread = time();

        $DB->insert_record('local_message_read', $readrecord);

    }
}

// Add to navigation block
function local_message_extend_settings_navigation($navigation, $context) {
    global $CFG;
    $parent = $navigation->find('courseadmin', navigation_node::TYPE_COURSE);
    if($parent == null) {
        return;
    }
    $parent->add('Set course color', '/admin/settings.php?section=themesettingmoovechild#theme_moovechild_subtheme', navigation_node::TYPE_SETTING);
}

function retrieve_course_svg() {
    // if we're in the course context, retrieve the course svg

    //need to check which course we are in
    global $COURSE;
    $course_id = $COURSE->id;

    //$course_id -= 1;

    if($course_id > 1) {
        $context = context_course::instance($course_id);
        $courseSelector = 'courseColor'.$course_id;
        $coursecolor = get_config('theme_moovechild', $courseSelector);
    } else {
        $coursecolor = false;
    }
}

