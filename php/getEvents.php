<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Event.php";

// TODO combine this file with php/getEventInfo.php. Why do we have 2 getEvent files?. Update front end as needed

function getSetupEvents() {
    $dbEvents = DbClass::getAllEventsAfterCurrentDate();
    $events   = array();
    foreach ($dbEvents as $row) {
        $event = new Event();
        $event->createNew($row["Eventid"], $row["Name"], $row["Date"], $row["Description"]);
        $event->populateAttendeeList();
        array_push($events, $event);
    }
         return $events;

    }

    function getAllEvents(){
         $dbEvents = DbClass::getAllEvents();
         $events = array();
         foreach($dbEvents as $row){
             $event = new Event();
             $event->createNew($row["Eventid"], $row["Name"], $row["Date"], $row["Description"]);
             $event->populateAttendeeList();
             array_push($events, $event);
         }
         return $events;
    }

    function searchEventsByName($query){
        $dbEvents = DbClass::getEventsByName($query);
        $events = array();
        foreach($dbEvents as $row){
            $event = new Event();
            $event->createNew($row["Eventid"], $row["Name"], $row["Date"], $row["Description"]);
            $event->populateAttendeeList();
            array_push($events, $event);
        }
        return $events;
    }
