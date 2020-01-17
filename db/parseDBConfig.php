<?php
	function parseDBConfig(){
		$root = $_SERVER['DOCUMENT_ROOT'];
		$config = parse_ini_file("db.ini"); //Grab configuration info for DB connection
		return $config;
	}
?>