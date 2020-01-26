<?php
    function findName($name, $event){
        require_once "../db/dbInterface.php";
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