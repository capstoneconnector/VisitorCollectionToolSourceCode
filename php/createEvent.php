<?php
require_once "../db/classes/DbClass.php";
//require_once "classes/Event.php";

function createEvent($name, $description, $date){
    return DbClass::addEvent($name, $description, $date);
}
