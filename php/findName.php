<?php
    function findName($name, $event){
        include_once "../db/getAttendeeInfo.php";
        $names = explode(" ", $name);
        if(sizeof($names) == 2){
	        $fname = $names[0];
	        $lname = $names[1];
	        return getAttendeeInfoFromName($event, $fname, $lname);
	    }
	    else{
			return NULL;
	    }
    }
?>