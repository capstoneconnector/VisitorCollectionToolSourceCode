<?php
require_once "connect.php";
/*
 * each table will have the following basic functionality
 * get -> read, add -> insert, update, delete,
 * TODO current get...() functions should be named read...()
 * TODO current add...() functions should be named insert...()
 */


function registerUser($fname, $lname, $email, $event){
    include_once "../php/parseConfig.php";
    addAttendee($fname, $lname, $email, $event);
    //checkinAttendee();
	$cfg = parseConfig();
	$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
	$stmt = $pdo->prepare("INSERT INTO attendee(Fname,Lname,Email,Eventid,Attended) VALUES(?,?,?,?,TRUE)"); //Add attendee to DB and set them as attended
	$stmt->bindParam(1,$fname);
	$stmt->bindParam(2,$lname);
	$stmt->bindParam(3,$email);
    $stmt->bindParam(4,$event);

	//return $stmt->execute();
    if ($stmt->execute())
    {
        return true;
    } else {
        return false;
    }
}

function readAttendeeById(int $id)
{
    $pdo = newPDO();
    $properties = "Id, Fname, Lname, Email";
    $table = "attendee";
    $conditional = "attendee = {$id}";
    $statement = $pdo->prepare("SELECT {$properties} from {$table} WHERE {$conditional}");

    $attendees = array();
    if($statement->execute())
    {
        while($row = $statement->fetch())
        {
            array_push($attendees, $row);
        }
    }
    return $attendees;
}

function insertAttendee(Attendee $attendee): bool
{
    $pdo = newPDO();
    $table = "attendee(Fname, Lname, Email, Phone)";
    $values = "values({$attendee->getFname()}, {$attendee->getLname()}, {$attendee->getEmail()}, {$attendee->getPhone()})";
    $statement = $pdo->prepare("INSERT INTO {$table} {$values}");
    return $statement->execute();
}

function updateAttendee(int $id, Attendee $attendee) // TODO implement the prepare statement to update existing attendee with new attendee
{
    $pdo = newPDO();

    $conditional = "WHERE id={$id}";
    $statement = $pdo->prepare("");
    return $statement->execute();
}

function deleteAttendee($id) // TODO implement deleting attendee from database.
{
    $pdo = newPDO();

    $conditional = "WEHRE id={$id}";
    $statement = $pdo->prepare("");
    return $statement->execute();
}

function addAttendee($fname, $lname, $email, $event){
	include_once "../php/parseConfig.php";
	$cfg = parseConfig();
	$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
	$stmt = $pdo->prepare("INSERT INTO attendee(Fname, Lname, Email, Eventid, Attended) VALUES(?, ?, ?, ?, FALSE)"); //Add attendee to DB
	$stmt->bindParam(1, $fname);
	$stmt->bindParam(2, $lname);
	$stmt->bindParam(3, $email);
	$stmt->bindParam(4, $event);

	return $stmt->execute();
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
	include_once "../php/parseConfig.php";
	$cfg = parseConfig();
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

function readEventById($id)
{
    $pdo = newPDO();

    $conditional = "eventId = {$id}";
    $statement = $pdo->prepare("SELECT * FROM event WHERE {$conditional}");

    return $info = $statement->fetch();
}

function insertEvent(Event $event)
{
    $pdo = newPDO();
    $table = "event(Name, Description, Date, Ebid)";
    $values = "values({$event->getName()}, {$event->getDescription()}, {$event->getDate()}, {$event->getEventbriteId()})";
    $statement = $pdo->prepare("INSERT into {$table} {$values}");
    return $statement->execute();
}

function updateEvent(int $id, Event $event) // TODO complete the prepare statement to update an event following the rough guide of $event and $values
{
    if ($currentEvent = getEventById($id))
    {
        $pdo = newPDO();

        $event = "{$currentEvent} ";
        $values = "values({$event->getName()}, {$event->getDescription()}, {$event->getDate()}, {$event->getEventbriteId()}, {$event->getAttendees()}";

        $statement = $pdo->prepare("");
        return $statement->execute();
    } else {
        return new InvalidArgumentException("event id does not exist in the database");
    }
}

function deleteEvent($id) //TODO should this method also delete all of the attendance records associated with this event?
{
    $pdo = newPDO();

    $statement = $pdo->prepare("");
    return $statement->execute();
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

function verifyLogin($username, $password){
    require_once "../php/parseConfig.php";
    $cfg = parseConfig();
    $pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
    $hashedpass = sha1($password);
    $stmt = $pdo->prepare("SELECT COUNT(Username) AS num FROM user WHERE Username = ? AND Password = ?");
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $hashedpass);
    if($stmt->execute())
    {
        $info = $stmt->fetch();
        if($info['num'] == 1)
        {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
}