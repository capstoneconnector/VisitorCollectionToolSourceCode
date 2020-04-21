<?php
require_once "../backend/classes/EventManager.php";
require_once "../backend/createEventTable.php";
$query  = $_REQUEST['query'];
$events = EventManager::searchEventsByName($query);
echo createEventTable($events);
