<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Attendance.php";

function getAttendanceRecord($event, $attendee){
    $dbAttendance = DbClass::getAttendance($event->getId(), $attendee->getId());
    $attendance = new Attendance();
    $attendance->createNew($dbAttendance["Eventid"], $dbAttendance["Attendeeid"], $dbAttendance["Registered"], $dbAttendance["Walkin"], $dbAttendance["Attended"]);
    return $attendance;
}
