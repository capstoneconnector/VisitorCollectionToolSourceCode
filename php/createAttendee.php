<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Attendee.php";

// TODO compare to php/createEvent.php. One returns bool, the other returns the object. See source code.
// Choose one return type or name them differently. ex. createAttendee():bool and getAttendee():Attendee.

function createAttendee($fname, $lname, $email, $gender, $phone) {
    $attendee = new Attendee();
    $attendee->create($fname, $lname, $email, $gender, $phone);
    $attendee->save();
    return $attendee;
}