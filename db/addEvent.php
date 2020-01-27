<?php
	function addEvent($name, $date, $description){
		require_once "parseDBConfig.php";
		$cfg = parseDBConfig();
		$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
		$stmt = $pdo->prepare("INSERT into event(Name, Description, Date) values(?, ?, ?)"); //Add event into DB
		$stmt->bindParam(1, $name);
		$stmt->bindParam(2, $description);
		$stmt->bindParam(3, $date);
		if ($stmt->execute())
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
?>