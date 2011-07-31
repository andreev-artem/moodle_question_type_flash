<?php
/**
 * Defines the editing form for the flash question type.
 *
 * @copyright 2007 Dmitry Pupinin, 2011 Artem Andreev (andreev.artem@gmail.com)
 * @author Dmitry Pupinin dlnsk@ngs.ru
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package questions
 */
require_once($CFG->dirroot.'/question/type/edit_question_form.php');

/**
 * flash editing form definition.
 */
class question_edit_flash_form extends question_edit_form {
	
    function qtype() {
        return 'flash';
    }

    function definition_inner(&$mform) {
        $mform->addElement('filemanager', 'flashobject', get_string('flashobject', 'qtype_flash'), null,
            array('subdirs'=>0,
                  'maxfiles'=>1,
                  'accepted_types'=>array('.swf')));
        $mform->addRule('flashobject', null, 'required', null, 'client');
        $mform->addElement('static', 'warning', '', get_string('flashwarning', 'qtype_flash'));

        $mform->addElement('text', 'flashwidth', get_string('flashwidth', 'qtype_flash'),
                array('size' => 4));
        $mform->setType('flashwidth', PARAM_INT);
        $mform->setDefault('flashwidth', 640);
        $mform->addRule('flashwidth', null, 'required', null, 'client');

        $mform->addElement('text', 'flashheight', get_string('flashheight', 'qtype_flash'),
                array('size' => 4));
        $mform->setType('flashheight', PARAM_INT);
        $mform->setDefault('flashheight', 480);
        $mform->addRule('flashheight', null, 'required', null, 'client');

        $mform->addElement('filemanager', 'optionalfile', get_string('optionalfile', 'qtype_flash'), null,
            array('subdirs'=>0,
                  'maxfiles'=>1,
                  'accepted_types'=>'*'));
        $mform->addHelpButton('optionalfile', 'optionalfile', 'qtype_flash');
        $mform->setAdvanced('optionalfile');

        $mform->addElement('textarea', 'optionaldata', get_string('optionaldata', 'qtype_flash'), 'wrap="virtual" rows="10" cols="45"');
        $mform->addHelpButton('optionaldata', 'optionaldata', 'qtype_flash');
        $mform->setAdvanced('optionaldata');
    }

    function data_preprocessing($question) {
        $draftid = file_get_submitted_draft_itemid('flashobject');
        file_prepare_draft_area($draftid,
                    $this->context->id,
                    'qtype_flash',
                    'flashobject',
                    !empty($question->id)?(int)$question->id:null,
                    array('subdirs' => 0, 'maxfiles' => 1));
        $question->flashobject = $draftid;

        $draftid = file_get_submitted_draft_itemid('optionalfile');
        file_prepare_draft_area($draftid,
                    $this->context->id,
                    'qtype_flash',
                    'optionalfile',
                    !empty($question->id)?(int)$question->id:null,
                    array('subdirs' => 0, 'maxfiles' => 1));
        $question->optionalfile = $draftid;
        
        return $question;
    }
}
?>
