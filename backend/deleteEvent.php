<?php
require_once "../db/classes/DbClass.php";
$eventId = $_REQUEST["eventid"];
if (!empty($eventId)) {
    return (DbClass::deleteAttendanceByEventId($eventId) and DbClass::deleteEventById($eventId));
} else {
    echo "There was an error deleting this event!";
}