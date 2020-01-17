<?php
	function parseDBConfig(){
		$root = $_SERVER['DOCUMENT_ROOT'];
		$config = parse_ini_file("db.ini");
		return $config;
	}
?>