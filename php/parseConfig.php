<?php
	function parseConfig(){
		$config = parse_ini_file("../config.ini");
		return $config;
	}
?>