<?php
	function parseDBConfig(){
		$config = parse_ini_file("db.ini"); //Grab configuration info for DB connection
		return $config;
	}
?>