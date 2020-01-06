<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	include_once $root . "/db/connect.php";
	$userid = $_REQUEST["userid"];
	if(!empty($userid)){
		$stmt = $pdo->prepare("UPDATE attendee SET Attended = 1 WHERE Id = ?");
		$stmt->bindParam(1, $userid);
		$stmt->execute();	
	}
?>