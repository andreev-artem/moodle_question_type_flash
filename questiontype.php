<?php

/**
 * Question type class for the flash question type.
 *
 * @package    qtype
 * @subpackage flash
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * The flash question type.
 *
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_flash extends question_type {
    public function is_manual_graded() {
        return true;
    }

    public function get_question_options($question) {
        global $DB;

        $question->options = $DB->get_record('qtype_flash_options', array('questionid' => $question->id), '*', MUST_EXIST);

        return parent::get_question_options($question);
    }

    public function save_question_options($formdata) {
        global $DB;
        $context = $formdata->context;

        $options = $DB->get_record('qtype_flash_options', array('questionid' => $formdata->id));
        if (!$options) {
            $options = new stdClass();
            $options->questionid = $formdata->id;
            $options->flashobject = $formdata->flashobject;
            $options->id = $DB->insert_record('qtype_flash_options', $options);
        }

        file_save_draft_area_files($formdata->flashobject,
                $context->id, 'qtype_flash', 'flashobject', $options->questionid);
        $options->flashobject = $formdata->flashobject;
        $options->width = $formdata->flashwidth;
        $options->height = $formdata->flashheight;
        $options->optionaldata = $formdata->optionaldata;
        
        $DB->update_record('qtype_flash_options', $options);

        return true;
    }

    protected function initialise_question_instance(question_definition $question, $questiondata) {
        parent::initialise_question_instance($question, $questiondata);

        $question->width = $questiondata->options->width;
        $question->height = $questiondata->options->height;
        $question->optionaldata = $questiondata->options->optionaldata;
    }

    /**
     * @return array the different response formats that the question type supports.
     * internal name => human-readable name.
     */
/*    public function response_formats() {
        return array(
            'editor' => get_string('formateditor', 'qtype_essay'),
            'editorfilepicker' => get_string('formateditorfilepicker', 'qtype_essay'),
            'plain' => get_string('formatplain', 'qtype_essay'),
            'monospaced' => get_string('formatmonospaced', 'qtype_essay'),
        );
    }

    /**
     * @return array the choices that should be offered for the input box size.
     */
/*    public function response_sizes() {
        $choices = array();
        for ($lines = 5; $lines <= 40; $lines += 5) {
            $choices[$lines] = get_string('nlines', 'qtype_essay', $lines);
        }
        return $choices;
    }

    /**
     * @return array the choices that should be offered for the number of attachments.
     */
/*    public function attachment_options() {
        return array(
            0 => get_string('no'),
            1 => '1',
            2 => '2',
            3 => '3',
            -1 => get_string('unlimited'),
        );
    }*/

    public function move_files($questionid, $oldcontextid, $newcontextid) {
        parent::move_files($questionid, $oldcontextid, $newcontextid);
        $fs = get_file_storage();
        $fs->move_area_files_to_new_context($oldcontextid,
                $newcontextid, 'qtype_flash', 'flashobject', $questionid);
    }

    protected function delete_files($questionid, $contextid) {
        parent::delete_files($questionid, $contextid);
        $fs = get_file_storage();
        $fs->delete_area_files($contextid, 'qtype_flash', 'flashobject', $questionid);
    }
}
