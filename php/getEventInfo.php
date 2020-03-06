<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Event.php";


function getEvent($id){
    return new Event($id);

}

