<?php
	function registerUser($fname, $lname, $email, $event){
		require_once "parseDBConfig.php";
		$cfg = parseDBConfig();
		$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
		$stmt = $pdo->prepare("INSERT INTO attendee(Fname,Lname,Email,Eventid,Attended) VALUES(?,?,?,?,TRUE)"); //Add attendee to DB and set them as attended
		$stmt->bindParam(1,$fname);
		$stmt->bindParam(2,$lname);
		$stmt->bindParam(3,$email);
		$stmt->bindParam(4,$event);
		
		if($stmt->execute()){
			return TRUE;
		}

		else{
			return FALSE;
		}

	}
?>