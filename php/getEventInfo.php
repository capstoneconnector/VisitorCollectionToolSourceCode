<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Event.php";

function getEvent($id){
    $dbEvent = DbClass::getEventByID($id);
    $event = new Event();
    $event->createNew($dbEvent["Eventid"], $dbEvent["Name"], $dbEvent["Date"], $dbEvent["Description"]);
    $event->populateAttendeeList();
    return $event;
}

/*
function getEventNew($id){
    return new Event($id);

}
*/
