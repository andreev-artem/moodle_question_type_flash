<?php
/**
 * Flash question definition class.
 *
 * @package    qtype
 * @subpackage flash
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Represents an flash question.
 *
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_flash_question extends question_graded_automatically {
    public $width;
    public $height;
    public $optionaldata;

/*    public function make_behaviour(question_attempt $qa, $preferredbehaviour) {
        question_engine::load_behaviour_class('manualgraded');
        return new qbehaviour_manualgraded($qa, $preferredbehaviour);
    }*/
    public function get_validation_error(array $response) {
        return '';
    }

    public function grade_response(array $response) {
        $fraction = $response['grade'];
        return array($fraction, question_state::graded_state_for_fraction($fraction));
    }

    public function get_expected_data() {
        $vars = array();
        $vars['flashdata'] = PARAM_RAW;
        $vars['grade'] = PARAM_FLOAT;

        return $vars;
    }

    public function summarise_response(array $response) {
        if (isset($response['answer'])) {
            $formatoptions = new stdClass();
            $formatoptions->para = false;
            return html_to_text(format_text(
                    $response['answer'], FORMAT_HTML, $formatoptions), 0, false);
        } else {
            return null;
        }
    }

    public function get_correct_response() {
        return null;
    }

    public function is_complete_response(array $response) {
        return true;
    }

    public function is_same_response(array $prevresponse, array $newresponse) {
        return false;
    }

    public function check_file_access($qa, $options, $component, $filearea, $args, $forcedownload) {
        if ($filearea == 'flashobject') {
            return true;
        } else {
            return parent::check_file_access($qa, $options, $component,
                    $filearea, $args, $forcedownload);
        }
    }
}
