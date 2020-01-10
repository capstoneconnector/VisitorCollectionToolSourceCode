<?php
	include_once "connect.php";
	function registerUser($fname, $lname, $email, $event){
		global $pdo;
		$stmt = $pdo->prepare("INSERT INTO attendee(Fname,Lname,Email,Eventid,Attended) VALUES(?,?,?,?,FALSE)");
		$stmt->bindParam(1,$fname);
		$stmt->bindParam(2,$lname);
		$stmt->bindParam(3,$email);
		$stmt->bindParam(4,$event);
		$stmt->execute();
	}
?>