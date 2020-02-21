<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Event.php";

function findName($name, $event){
    $names = explode(" ", $name);
    if(sizeof($names) == 2){
        $fname = $names[0];
        $lname = $names[1];
        $result = [];
        foreach($event->getAttendees() as $attendee){
                if(DbClass::checkAttendanceByID($attendee->getId(), $event->getId()) == FALSE and matchName($fname, $attendee->getFname()) and matchName($lname, $attendee->getLname())){
                    array_push($result, $attendee);
                }
        }

        return $result;
    }
    else{
        return NULL;
    }
}

function matchName($enteredName, $actualName){
    if(preg_match("/\w*(?i)" . $enteredName . "\w*/", $actualName)){
        return TRUE;
    }
    else{
        return FALSE;
    }
}
