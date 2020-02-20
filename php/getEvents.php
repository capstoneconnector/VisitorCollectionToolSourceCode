<?php
    require_once "../db/classes/DbClass.php";
    require_once "classes/Event.php";
    function getSetupEvents(){
         $dbEvents = DbClass::getAllEventsAfterCurrentDate();
         $events = array();
         var_dump($dbEvents);
         foreach($dbEvents as $row){
            $event = new Event();
            $event->createNew($row["Eventid"], $row["Name"], $row["Date"], $row["Description"]);
            $event->populateAttendeeList();
            array_push($events, $event);
         }
         return $events;

     }
