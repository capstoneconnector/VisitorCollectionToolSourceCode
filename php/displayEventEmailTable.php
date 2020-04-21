<?php
require_once "../php/classes/EventManager.php";
require_once "../php/createEventTable.php";
$startDate = $_REQUEST['startDate'];
$endDate = $_REQUEST['endDate'];
$events = EventManager::getEventsByDateRange($startDate, $endDate);
echo createEventTable($events, true);