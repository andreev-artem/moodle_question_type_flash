<?php

defined('MOODLE_INTERNAL') || die();


/**
 * Serve question type files
 *
 * @since 2.0
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function qtype_flash_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload) {
    global $DB, $CFG;
    require_once($CFG->libdir . '/questionlib.php');
    question_pluginfile($course, $context, 'qtype_flash', $filearea, $args, $forcedownload);
}
