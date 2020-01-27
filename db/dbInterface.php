<?php
function registerUser($fname, $lname, $email, $event){
	include_once "../php/parseConfig.php";
	$cfg = parseConfig();
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

function addAttendee($fname, $lname, $email, $event){
	include_once "../php/parseConfig.php";
	$cfg = parseConfig();
	$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
	$stmt = $pdo->prepare("INSERT INTO attendee(Fname, Lname, Email, Eventid, Attended) VALUES(?, ?, ?, ?, FALSE)"); //Add attendee to DB
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


function getAttendeeInfoFromName($event, $fname, $lname){
	include_once "../php/parseConfig.php";
	$cfg = parseConfig();
	$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
	$info = array();
	$stmt = $pdo->prepare("SELECT Id, Fname, Lname, Email FROM attendee WHERE Eventid = ? AND Attended = 0 AND Fname LIKE CONCAT('%',?,'%') AND Lname LIKE CONCAT('%',?,'%')"); //Find all attendees with similar first and last names entered
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

function getAttendeeInfoByEventId($eventId){
	include_once "parseDBConfig.php";
	$cfg = parseDBConfig();
	$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
	$info = array();
	$stmt = $pdo->prepare("SELECT Id, Fname, Lname, Email, Phone, Attended FROM attendee WHERE Eventid = $eventId"); //Find all attendees by eventId
	$stmt->bindParam(1, $eventId);
	if($stmt->execute()){
		while($row = $stmt->fetch()){
			array_push($info, $row);
		}
	}
	return $info;
}

function getAttendeeCount($fname, $lname, $email, $event){
	include_once "../php/parseConfig.php";
	$cfg = parseConfig();
	$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
	$info = array();
	$stmt = $pdo->prepare("SELECT COUNT(*) AS num FROM attendee WHERE Eventid = ? AND Fname = ? AND Lname = ? AND Email = ?");
	//Fetch amount of attendees with name, event, and email entered. Should be 0 or 1.
    $stmt->bindParam(1, $event);
    $stmt->bindParam(2, $fname);
    $stmt->bindParam(3, $lname);
    $stmt->bindParam(4, $email);
    if($stmt->execute()){
        $info = $stmt->fetch();
    }
    return $info;
}

function addEvent($name, $date){
	include_once "../php/parseConfig.php";
	$cfg = parseConfig();
	$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
	$stmt = $pdo->prepare("INSERT into event(Name, Date) values(?, ?)"); //Add event into DB
	$stmt->bindParam(1, $name);
	$stmt->bindParam(2, $date);
	if ($stmt->execute())
	{
		return TRUE;
	}
	else{
		return FALSE;
	}
}

function getAllEvents() {
	include_once "../php/parseConfig.php";
	$cfg = parseConfig();
	$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
	$statement = $pdo->prepare("SELECT * FROM event"); //Fetch all events
	$info = array();
	if($statement->execute()) {
        while($row = $statement->fetch()) {
            array_push($info, $row);
        }
	}
	return $info;
}

function getEventById($id) {
	include_once "../php/parseConfig.php";
	$cfg = parseConfig();
	$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
	$statement = $pdo->prepare("SELECT * FROM event WHERE Eventid=?"); //Fetch specific event by id
	$statement->bindParam(1, $id);
	$statement->execute();
	return $info = $statement->fetch();
}




?>