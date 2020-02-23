<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Attendee.php";

function createAttendee($fname, $lname, $phone, $email){
    $attendee = new Attendee();
    $attendeeID = DbClass::addAttendee($fname, $lname, $phone, $email);
    $attendee->createNew($attendeeID, $fname, $lname, $phone, $email);
    return $attendee;
}