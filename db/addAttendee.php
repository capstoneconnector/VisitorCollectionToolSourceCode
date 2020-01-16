<?php
	function registerUser($fname, $lname, $email, $event){
		$pdo = new PDO('mysql:host=localhost;dbname=icdb', "root", "");
		$stmt = $pdo->prepare("INSERT INTO attendee(Fname,Lname,Email,Eventid,Attended) VALUES(?,?,?,?,TRUE)");
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