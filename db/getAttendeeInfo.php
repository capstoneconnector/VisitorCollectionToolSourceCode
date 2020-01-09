<?php
	function getAttendeeInfoFromName($event, $fname, $lname){
		include_once "connect.php";
		$info = array();
		$stmt = $pdo->prepare("SELECT Id, Fname, Lname, Email FROM attendee WHERE Eventid = ? AND Attended = 0 AND Fname LIKE CONCAT('%',?,'%') AND Lname LIKE CONCAT('%',?,'%')");
	    $stmt->bindParam(1, $event);
	    $stmt->bindParam(2, $fname);
	    $stmt->bindParam(3, $lname);
	    if($stmt->execute()){
	        while($row = $stmt->fetch()){
	            array_push($info, $row);
	        }
	    }
	    return $info;
	}
?>