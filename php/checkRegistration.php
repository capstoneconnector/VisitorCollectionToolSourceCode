<?php
require_once "../db/classes/DbClass.php";
function checkRegistration($attendee, $event){ //Check if user is already registered for event
    return DbClass::isAttendeeRegistered($attendee->getId(), $event->getId());
}
