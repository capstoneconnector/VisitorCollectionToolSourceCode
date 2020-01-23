<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once $root."php/ebInterface.php";
require_once $root."db/connect.php";

function importEvents($oAuthToken) {
	$events = getAllEvents($oAuthToken);

	foreach ($events as $event) {
		$statement = $pdo->prepare("INSERT INTO event(Name, Date) VALUES(?, ?);") //add event id
		$statement->bindParam(1, $event["name"]);
		$statement->bindParam(2, $event["start"]["local"]);
		$statement->execute();
	}
}
?>