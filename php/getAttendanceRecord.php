<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Attendance.php";

function getAttendanceRecord($event, $attendee){
    $dbAttendance = DbClass::getAttendance($event->getId(), $attendee->getId());
    return new Attendance($event->getId(), $attendee->getId(), $dbAttendance["Registered"], $dbAttendance["Walkin"], $dbAttendance["Attended"]);
}
