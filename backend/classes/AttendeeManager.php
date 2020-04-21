<?php
require_once "../db/classes/DbClass.php";
require_once "../backend/classes/Attendee.php";


class AttendeeManager {
    static function checkAttendeeExists($fname, $lname, $email) {
        return DbClass::doesAttendeeExist($fname, $lname, $email);
    }

    static function createAttendee($fname, $lname, $email, $gender, $phone) {
        $attendee = new Attendee();
        $attendee->create($fname, $lname, $email, $gender, $phone);
        $attendee->save();
        return $attendee;
    }

    static function getAttendeeFromAttributes($fname, $lname, $email) {
        $attendee   = new Attendee();
        $dbAttendee = DbClass::getAttendeeByName($fname, $lname, $email);
        $attendee->createNew($dbAttendee["Id"], $dbAttendee["Fname"], $dbAttendee["Lname"], $dbAttendee["Email"], $dbAttendee["Phone"], $dbAttendee["Gender"]);
        return $attendee;
    }

    static function getAttendeeInfoByID($id) {
        $attendee   = new Attendee();
        $dbAttendee = DbClass::getAttendeeByID($id);
        $attendee->createNew($dbAttendee["Id"], $dbAttendee["Fname"], $dbAttendee["Lname"], $dbAttendee["Email"], $dbAttendee["Phone"], $dbAttendee["Gender"]);
        return $attendee;
    }

    static function getAllAttendees() {
        $dbAttendees = DbClass::getAllAttendees();
        $attendees   = array();
        foreach ($dbAttendees as $dbAttendee) {
            $attendee = new Attendee();
            $attendee->createNew($dbAttendee["Id"], $dbAttendee["Fname"], $dbAttendee["Lname"], $dbAttendee["Email"], $dbAttendee["Phone"], $dbAttendee["Gender"]);
            array_push($attendees, $attendee);
        }
        return $attendees;
    }
}