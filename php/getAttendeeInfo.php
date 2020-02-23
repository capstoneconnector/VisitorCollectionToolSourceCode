<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Attendee.php";

function getAttendeeFromAttributes($fname, $lname, $email){
    $attendee = new Attendee();
    $dbAttendee = DbClass::getAttendeeByName($fname, $lname, $email);
    $attendee->createNew($dbAttendee["Id"], $dbAttendee["Fname"], $dbAttendee["Lname"], $dbAttendee["Phone"], $dbAttendee["Email"]);
    return $attendee;
}
