<?php
include_once "../db/importEbEvent.php";

class importEbEventIntoDb extends PHPUnit_Framework_TestCase { //Run this file with phpunit command from command line
	function runImportEvents() {
		$oAuthToken = "COKR3D7YQAPZM2GWLOTL"
		importEvents($oAuthToken);
	}
}
?>