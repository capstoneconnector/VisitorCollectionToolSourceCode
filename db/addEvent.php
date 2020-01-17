<?php
	function addEvent($name, $date){
		include_once "parseDBConfig.php";
		$cfg = parseDBConfig();
		$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
		$stmt = $pdo->prepare("INSERT into event(Name, Date) values(?, ?)"); //Add event into DB
		$stmt->bindParam(1, $name);
		$stmt->bindParam(2, $date);
		if ($stmt->execute())
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
?>