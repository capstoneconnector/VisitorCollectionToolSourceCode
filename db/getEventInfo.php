<?php
	function getAllEvents() {
		require_once "parseDBConfig.php";
		$cfg = parseDBConfig();
		$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
		$statement = $pdo->prepare("SELECT * FROM event"); //Fetch all events
		$info = array();
		if($statement->execute()) {
	        while($row = $statement->fetch()) {
	            array_push($info, $row);
	        }
		}
		return $info;
	}

	function getEventById($id) {
		require_once "parseDBConfig.php";
		$cfg = parseDBConfig();
		$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
		$statement = $pdo->prepare("SELECT * FROM event WHERE Eventid=?"); //Fetch specific event by id
		$statement->bindParam(1, $id);
		$statement->execute();
		return $info = $statement->fetch();
	}
?>