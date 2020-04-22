<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Attendee.php";
require_once "../backend/classes/AttendeeManager.php";

$userid = $_REQUEST["userid"];
$fname  = $_REQUEST['fname'];
$lname  = $_REQUEST['lname'];
$email  = $_REQUEST['email'];
$phone  = $_REQUEST['phone'];
if (!empty($userid)) {
    $attendee = AttendeeManager::getAttendeeInfoByID($userid);
    $attendee->setFirstName($fname);
    $attendee->setLastName($lname);
    $attendee->setEmail($email);
    $attendee->setPhone($phone);
    $attendee->save();
}