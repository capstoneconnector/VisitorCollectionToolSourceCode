<?php
	function checkRegistration($fname, $lname, $email, $event){ //Check if user is already registered for event
		$root = $_SERVER['DOCUMENT_ROOT'];
   		include_once $root . "/db/getAttendeeInfo.php";
		$registered = FALSE;
		$info = getAttendeeCount($fname, $lname, $email, $event);
		if($info['num'] > 0){
			$registered = TRUE;
		}
		return $registered;
	}
?>