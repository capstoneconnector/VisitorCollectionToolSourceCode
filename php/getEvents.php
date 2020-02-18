<?php
    function getSetupEvents(){
         $dbEvents = DbClass::getAllEventsAfterCurrentDate();
         $events = array();
         foreach($dbEvents as $row){
            $event = new Event();
            $event->createNew($row["Name"], $row["Date"], $row["Description"], $row["Eventid"]);
            $event->populateAttendeeList();
            array_push($events, $event);
         }
         return $events;

     }
