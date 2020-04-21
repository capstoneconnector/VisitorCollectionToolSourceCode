<?php

require_once "../db/classes/DbClass.php";
require_once "../backend/classes/Event.php";

class EventManager {
    static function createEvent($name, $description, $date) {
        $event = new Event();
        $event->create($name, $date, $description);
        return $event->save();
    }

    static function getEvent($id) {
        return new Event($id);
    }

    static function getSetupEvents() {
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

    static function getAllEvents() {
        $dbEvents = DbClass::getAllEvents();
        $events   = array();
        foreach ($dbEvents as $row) {
            $event = new Event();
            $event->createNew($row["Eventid"], $row["Name"], $row["Date"], $row["Description"]);
            $event->populateAttendeeList();
            array_push($events, $event);
        }
        return $events;
    }

    static function searchEventsByName($query) {
        $dbEvents = DbClass::getEventsByName($query);
        $events   = array();
        foreach ($dbEvents as $row) {
            $event = new Event();
            $event->createNew($row["Eventid"], $row["Name"], $row["Date"], $row["Description"]);
            $event->populateAttendeeList();
            array_push($events, $event);
        }
        return $events;
    }

    static function getEventsRegisteredFor($attendeeID) {
        $dbEvents = DbClass::getEventsRegisteredFor($attendeeID);
        $events   = array();
        foreach ($dbEvents as $row) {
            $event = new Event();
            $event->createNew($row["Eventid"], $row["Name"], $row["Date"], $row["Description"], $row['Ebid']);
            $event->populateAttendeeList();
            array_push($events, $event);
        }
        return $events;
    }

    static function getEventsByDateRange($startDate, $endDate) {
        if ($startDate<$endDate) {
            $dbEvents = DbClass::readAllEventsBetweenDates($startDate, $endDate);
            $events   = array();
            foreach ($dbEvents as $row) {
                $event = new Event();
                $event->createNew($row["Eventid"], $row["Name"], $row["Date"], $row["Description"], $row['Ebid']);
                $event->populateAttendeeList();
                array_push($events, $event);
            }
            return $events;
        } else {
            echo "Wrong dates";
        }
    }
}