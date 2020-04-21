<?php
require_once "../php/classes/EventManager.php";
require_once "../php/createEventTable.php";
$query = $_REQUEST['query'];
$events = EventManager::searchEventsByName($query);
echo createEventTable($events);
