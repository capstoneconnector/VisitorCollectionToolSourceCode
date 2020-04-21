<?php
require_once "../db/classes/DbClass.php";
require_once "../backend/classes/Event.php";
require_once "../backend/mailer.php";
$eventsJSON = json_decode($_REQUEST["events"]);
$events     = [];
if (!empty($eventsJSON)) {
    foreach ($eventsJSON as $eventID) {
        array_push($events, new Event($eventID));
    }
    echo sendThankYouByEvents($events);
}


