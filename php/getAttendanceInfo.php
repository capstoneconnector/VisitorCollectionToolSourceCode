<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Attendance.php";

function getAttendanceProportion($eventid){
    return DbClass::getAttendanceByEventId($eventid);
}