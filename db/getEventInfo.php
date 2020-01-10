<?php
function getAllEvents() {
	include_once "connect.php";
	$statement = $pdo->prepare("SELECT * FROM event");
	$info = array();
	if($statement->execute()) {
        while($row = $statement->fetch()) {
            array_push($info, $row);
        }
	}
	return $info;
}

function getEventById($id) {
	include_once "connect.php";
	$statement = $pdo->prepare("SELECT * FROM event WHERE Eventid=?");
	$statement->bindParam(1, $id);
	$statement->execute();
	return $info = $statement->fetch();
}
?>