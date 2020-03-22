<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Attendee.php";

function getAttendeeFromAttributes($fname, $lname, $email){
    $attendee = new Attendee();
    $dbAttendee = DbClass::getAttendeeByName($fname, $lname, $email);
    $attendee->createNew($dbAttendee["Id"], $dbAttendee["Fname"], $dbAttendee["Lname"], $dbAttendee["Email"], $dbAttendee["Phone"], $dbAttendee["Gender"]);
    return $attendee;
}

function getAttendeeInfoByID($id){
    $attendee = new Attendee();
    $dbAttendee = DbClass::getAttendeeByID($id);
    $attendee->createNew($dbAttendee["Id"], $dbAttendee["Fname"], $dbAttendee["Lname"], $dbAttendee["Email"], $dbAttendee["Phone"], $dbAttendee["Gender"]);
    return $attendee;
}

function getAllAttendees(){
    $dbAttendees = DbClass::getAllAttendees();
    $attendees = array();
    foreach($dbAttendees as $dbAttendee){
        $attendee = new Attendee();
        $attendee->createNew($dbAttendee["Id"], $dbAttendee["Fname"], $dbAttendee["Lname"], $dbAttendee["Email"], $dbAttendee["Phone"], $dbAttendee["Gender"]);
        array_push($attendees, $attendee);
    }
    return $attendees;
}
