<?php
require_once "../db/classes/DbClass.php";

function registerAttendee($attendee, $event){
    if(DbClass::addWalkinRegistration($attendee->getId(), $event->getId())) {
        $event->addAttendee($attendee);
    }
    else{
        echo "Error adding attendee registration!";
    }
}
