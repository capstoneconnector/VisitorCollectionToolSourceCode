<?php
require_once "../backend/classes/EventManager.php";
require_once "../backend/createEventTable.php";
$startDate = $_REQUEST['startDate'];
$endDate   = $_REQUEST['endDate'];
$events    = EventManager::getEventsByDateRange($startDate, $endDate);
echo createEventTable($events, true);