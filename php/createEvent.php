<?php
require_once "../db/classes/DbClass.php";
//require_once "classes/Event.php";

function createEvent($name, $description, $date){
    $event = new Event();
    $event->create($name, $date, $description);
    return $event->save();
}
