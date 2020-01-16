<?php
	include_once "../db/addAttendee.php";

	class AddAttendeeTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
		public function setUp(){
	    	$this->eventid = 999;
		}
		public function tearDown(){
			$pdo = new PDO('mysql:host=localhost;dbname=icdb', "root", "");
			$stmt = $pdo->prepare("DELETE FROM attendee WHERE Eventid = 999 AND Email = 'jperson@gmail.com'");
			$stmt->execute();
		}

		function testAddAttendeeSuccess(){
			$this->assertTrue(registerUser("James", "Person", "jperson@gmail.com", $this->eventid));
		}
	}
?>