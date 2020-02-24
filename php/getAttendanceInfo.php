<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Attendance.php";

function getAttendanceByEventId($eventid){
    $attendance = new Attendance();
    $dbAttendance = DbClass::getAttendanceByEventId($eventid);
    $attendance->createNew($dbAttendance["Walk-in"], $dbAttendance["Registered"], $dbAttendance["Attended"]);
    return $attendance;
}