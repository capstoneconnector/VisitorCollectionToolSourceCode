<?php
require_once "../db/classes/DbClass.php";
require_once "../backend/classes/Attendance.php";

class AttendanceManager {
    static function checkRegistration($attendee, $event) { //Check if user is already registered for event
        return DbClass::isAttendeeRegistered($attendee->getId(), $event->getId());
    }

    static function findName($name, $event) {
        $names = explode(" ", $name);
        if (sizeof($names) == 2) {
            $fname  = $names[0];
            $lname  = $names[1];
            $result = [];
            foreach ($event->getAttendees() as $attendee) {
                if (DbClass::checkAttendanceByID($attendee->getId(), $event->getId()) == false and AttendanceManager::matchName($fname, $attendee->getFirstName()) and AttendanceManager::matchName($lname, $attendee->getLastName())) {
                    array_push($result, $attendee);
                }
            }

            return $result;
        } else {
            return null;
        }
    }

    static function matchName($enteredName, $actualName) {
        return preg_match("/\w*(?i)" . $enteredName . "\w*/", $actualName);

    }

    static function getAttendanceRecord($event, $attendee) {
        $dbAttendance = DbClass::getAttendance($event->getId(), $attendee->getId());
        $attendance   = new Attendance();
        $attendance->createNew($dbAttendance["Eventid"], $dbAttendance["Attendeeid"], $dbAttendance["Registered"], $dbAttendance["Walkin"], $dbAttendance["Attended"]);
        return $attendance;
    }

    static function registerAttendee($attendee, $event, $walkIn) {
        if (DbClass::addRegistration($attendee->getId(), $event->getId(), $walkIn)) {
            $event->addAttendee($attendee);
        } else {
            echo "Error adding attendee registration!";
        }
    }
}