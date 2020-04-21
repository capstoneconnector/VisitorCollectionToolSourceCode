<?php
require_once "../db/classes/DbClass.php";
$attendeeId = $_REQUEST["attendeeid"];
if (!empty($attendeeId)) {
    return (DbClass::deleteAttendanceByAttendeeId($attendeeId) and DbClass::deleteAttendeeById($attendeeId));
} else {
    echo "There was an error deleting this event!";
}
