<?php
	$hostname = "localhost";
	$username = "root";
	$db = "icdb";
	$password = "";
	$charset="utf8mb4";

	$dsn = "mysql:host=$hostname;dbname=$db;charset=$charset";

	$pdo = new PDO($dsn, $username, $password);

?>