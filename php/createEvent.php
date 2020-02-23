<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Event.php";

function createEvent($name, $description, $date){
    if(DbClass::addEvent($name, $description, $date)){
        return TRUE;
    }
    else{
        return FALSE;
    }

}
