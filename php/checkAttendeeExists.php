<?php
require_once "../db/classes/DbClass.php";

function checkAttendeeExists($fname, $lname, $email){
    DbClass::doesAttendeeExist($fname, $lname, $email);
}
