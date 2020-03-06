<?php
    require_once "../db/classes/DbClass.php";
	$userid = $_REQUEST["userid"];
	$eventid = $_REQUEST["eventid"];
	if(!empty($userid) and !empty($eventid)) {
        if(!DbClass::setAttendedTrue($userid, $eventid)){
            echo "Check in failed, contact an administrator";
        }
    }