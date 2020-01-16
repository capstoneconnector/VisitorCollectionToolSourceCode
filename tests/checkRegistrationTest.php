<?php
	include_once "../php/checkRegistration.php";

	class CheckRegistrationTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
		public function setUp(){
	    	$this->eventid = 999;
		}
		public function tearDown(){
		}

		function testCheckRegistrationFalse(){
			$this->assertFalse(checkRegistration("Bobby", "Jones", "bjones@gmail.com", $this->eventid));
	
		}

		function testCheckRegistrationTrue(){
			$this->assertTrue(checkRegistration("Mary", "Jane", "mjane@gmail.com", $this->eventid));
		}
	}
?>