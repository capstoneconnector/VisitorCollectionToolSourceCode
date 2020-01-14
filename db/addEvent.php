<?php
	function addEvent($name, $date){
		$pdo = new PDO('mysql:host=localhost;dbname=icdb', "root", "");
		$stmt = $pdo->prepare("INSERT into event(Name, Date) values(?, ?)");
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