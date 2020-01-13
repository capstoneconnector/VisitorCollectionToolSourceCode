<?php
	$root = $_SERVER["DOCUMENT_ROOT"];
	include_once $root . "/php/checkRegistration.php";

	class CheckRegistrationTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
		public function setUp(){
			$this->info = [["Bob","Jones","bjones@gmail.com",0],["Mary","Jane","mjane@gmail.com",1]];
		}
		public function tearDown(){
		}

		function testCheckRegistrationFalse(){
			$this->assertFalse(checkRegistration($this->info, "jsmith22@gmail.com"));
	
		}

		function testCheckRegistrationTrue(){
			$this->assertTrue(checkRegistration($this->info, "mjane@gmail.com"));
		}
	}
?>