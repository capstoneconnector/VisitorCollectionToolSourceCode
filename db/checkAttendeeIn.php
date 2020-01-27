<?php
	require_once "parseConfig.php";
	$cfg = parseConfig();
	$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
	$userid = $_REQUEST["userid"];
	if(!empty($userid)){
		$stmt = $pdo->prepare("UPDATE attendee SET Attended = 1 WHERE Id = ?"); //Set selected attendee entry as attended
		$stmt->bindParam(1, $userid);
		if($stmt->execute()){
			return TRUE;
		}	

		else{
			return FALSE;
		}
	}
	else{
		echo "Check in failed, contact an administrator!";
	}
?>