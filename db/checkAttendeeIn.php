<?php
	include_once "connect.php";
	$userid = $_REQUEST["userid"];
	if(!empty($userid)){
		$stmt = $pdo->prepare("UPDATE attendee SET Attended = 1 WHERE Id = ?");
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