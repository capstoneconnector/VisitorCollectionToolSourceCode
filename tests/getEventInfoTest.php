<?php
	include_once "../db/dbInterface.php";

	class GetEventInfo extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
		public function setUp(){
			$this->eventid = 999;
		}
		public function tearDown(){
		}

		function testGetEventByIdSuccess(){
			$this->assertSame(getEventById($this->eventid)['Name'], "Test Event");
		}

	}