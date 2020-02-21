<?php
require_once "../db/classes/DbClass.php";

function checkAttendeeExists($fname, $lname, $email){
    if(DbClass::doesAttendeeExist($fname, $lname, $email)){
        return TRUE;
    }
    else{
        return FALSE;
    }
}
