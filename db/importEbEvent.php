<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once $root."php/ebInterface.php";
include_once $root."db/connect.php";

function importEvents() {
	$allEvents = getAllEvents(/*OAuth*/);
	$statement = $pdo->prepare("INSERT INTO event(Name, Date) VALUES("Sample Event", "2020-02-01");")//add event id
}
?>