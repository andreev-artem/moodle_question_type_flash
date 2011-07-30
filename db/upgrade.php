<?php  //$Id: upgrade.php,v 1.1 2009/06/23 13:39:49 arborrow Exp $

// This file keeps track of upgrades to 
// the match qtype plugin
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installtion to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the functions defined in lib/ddllib.php

function xmldb_qtype_flash_upgrade($oldversion=0) {

    global $CFG, $DB;

    $dbman = $DB->get_manager();

/*    if ($oldversion < 2010121800) {
        $table = new xmldb_table('question_flash');
        $field = new xmldb_field('flashobject', XMLDB_TYPE_CHAR, '100', null, null, null, null, 'question');

        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
    }*/
    
    return true;
}

?>
