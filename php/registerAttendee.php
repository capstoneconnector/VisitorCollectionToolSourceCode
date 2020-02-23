<?php
require_once "../db/classes/DbClass.php";

function registerAttendee($attendee, $event, $walkIn){
    if(DbClass::addRegistration($attendee->getId(), $event->getId(), $walkIn)) {
        $event->addAttendee($attendee);
    }
    else{
        echo "Error adding attendee registration!";
    }
}
