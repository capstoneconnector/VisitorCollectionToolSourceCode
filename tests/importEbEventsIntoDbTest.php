<?php
include_once "../php/ebinterface.php";

class importEbEventIntoDb extends PHPUnit_Framework_TestCase { //Run this file with phpunit command from command line
	function runImportEvents() {
		$oAuthToken = "COKR3D7YQAPZM2GWLOTL"
		importEbEvents($oAuthToken);
	}
}
?>