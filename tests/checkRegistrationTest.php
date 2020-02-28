<?php
	require_once "../php/checkRegistration.php";
    require_once "../php/classes/Event.php";
    require_once "../php/classes/Attendee.php";

	class CheckRegistrationTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
		private $event, $registeredAttendee, $nonRegisteredAttendee;
	    public function setUp(){
	    	$this->event = new Event();
            $this->registeredAttendee = new Attendee();
            $this->nonRegisteredAttendee = new Attendee();
	    	$this->event->createNew(999, "Test Event", "2030-04-01", "");
	    	$this->registeredAttendee->createNew(10000, "Bob", "Jones", "555-5555", "bjones@gmail.com");
	    	$this->nonRegisteredAttendee->createNew(10001, "Mary", "Jane", "555-5555", "mjane@gmail.com");

		}
		public function tearDown(){
		}

		function testCheckRegistrationFalse(){
			$this->assertFalse(checkRegistration($this->nonRegisteredAttendee, $this->event));
	
		}

		function testCheckRegistrationTrue(){
			$this->assertTrue(checkRegistration($this->registeredAttendee, $this->event));
		}
	}