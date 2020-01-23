<?php
	include_once "../db/dbInterface.php";

	class GetAttendeeInfoTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
		public function setUp(){
			$this->eventid = 999;
		}
		public function tearDown(){
		}

		function testGetAttendeeCountOneResult(){
			$this->assertSame(getAttendeeCount("Bob", "Jones", "bjones@gmail.com", $this->eventid)['num'], "1");
		}

		function testGetAttendeeCountNoResult(){
			$this->assertSame(getAttendeeCount("Tommy", "Cat", "tommythecat@gmail.com", $this->eventid)['num'], "0");
		}
	}
?>