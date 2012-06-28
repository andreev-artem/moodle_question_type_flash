<?php

/**
 * Flash question renderer class.
 *
 * @package    qtype
 * @subpackage flash
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Generates the output for flash questions.
 *
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_flash_renderer extends qtype_renderer {

    public function head_code(question_attempt $qa) {
        global $PAGE;

        parent::head_code($qa);

        $PAGE->requires->js('/question/type/flash/flash_tag.js', true);
        $PAGE->requires->js('/question/type/flash/interface.js', true);
    }

    public function formulation_and_controls(question_attempt $qa,
            question_display_options $options) {
        global $CFG;

        $question = $qa->get_question();

        $qid = $question->id;
        $qName = 'q'.$qid;
        $readonly = $options->readonly ? '&qRO=1' : '';
        //$adaptive = ($cmoptions->optionflags & QUESTION_ADAPTIVE) ?  '&qAM=1' : '';
        $fillcorrect = $options->correctness == question_display_options::VISIBLE ? '&qFC=1' : '';

        $flashdata = $qa->get_last_qt_var('flashdata');
        $flashdata = $flashdata ? addslashes_js('&flData='.$flashdata) : '';
        //$description = !empty($state->options->answer) ? addslashes_js('&qDesc='.$state->options->answer) : '';
        $grade = '&qGr='.$qa->get_fraction();

        $flashobject = $this->get_file_url('flashobject', $options->context->id, $qid, $qa);
        $width  = $question->width;
        $height = $question->height;

        $qprefix = $qa->get_qt_field_name('');
        $optionaldata = !empty($question->optionaldata) ? addslashes_js('&optData='.$question->optionaldata) : '';

        // Print question formulation
        $formatoptions = new stdClass;
        $formatoptions->noclean = true;
        $formatoptions->para = false;
        $questiontext = $question->format_questiontext($qa);

        ob_start();
        include("$CFG->dirroot/question/type/flash/display.html");
        $result .= ob_get_contents();
        ob_end_clean();

        return $result;
    }

    private function get_file_url($filearea, $qcontextid, $qid, question_attempt $qa) {
        global $CFG;

        $fs = get_file_storage();
        if ($files = $fs->get_area_files($qcontextid, 'qtype_flash', $filearea, $qid, "timemodified", false)) {
            $file = array_shift($files);
            $filename = $file->get_filename();
            $usageid = $qa->get_usage_id();
            $slot = $qa->get_slot();
            $path = file_encode_url($CFG->wwwroot.'/pluginfile.php', "/$qcontextid/qtype_flash/$filearea/$usageid/$slot/$qid/$filename");
            return $path;
        }

        return '';
    }
}
