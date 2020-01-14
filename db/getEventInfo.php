<?php
	function getAllEvents() {
		$pdo = new PDO('mysql:host=localhost;dbname=icdb', "root", "");
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
		$pdo = new PDO('mysql:host=localhost;dbname=icdb', "root", "");
		$statement = $pdo->prepare("SELECT * FROM event WHERE Eventid=?");
		$statement->bindParam(1, $id);
		$statement->execute();
		return $info = $statement->fetch();
	}
?>