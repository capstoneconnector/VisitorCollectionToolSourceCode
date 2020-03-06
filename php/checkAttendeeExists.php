<?php
require_once "../db/classes/DbClass.php";

function checkAttendeeExists($fname, $lname, $email){
    return DbClass::doesAttendeeExist($fname, $lname, $email);
}
