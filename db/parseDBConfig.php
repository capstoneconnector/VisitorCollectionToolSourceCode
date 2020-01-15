<?php
	function parseDBConfig(){
		$root = $_SERVER['DOCUMENT_ROOT'];
		$config = parse_ini_file($root . "/db/db.ini");
		return $config;
	}
?>