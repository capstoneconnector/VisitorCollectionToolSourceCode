<?php
function checkRegistration($info,$email){ //Check if user is already registered for event by email
		$registered = FALSE;
		for($i = 0; $i < sizeof($info); $i++){
			if($email == $info[$i][2]){
				$registered = TRUE;
			}
		}
		return $registered;
	}
?>