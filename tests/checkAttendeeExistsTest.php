<?php
include_once "../businessLogic/checkAttendeeExists.businessLogic";

class CheckAttendeeExistsTest extends PHPUnit_Framework_TestCase { //Run this file with phpunit command from command line
    public function setUp() {
    }

    public function tearDown() {
    }

    function testCheckAttendeeExistsTrue() {
        $this->assertTrue(checkAttendeeExists("Bob", "Jones", "bjones@gmail.com"));
    }

		function testCheckAttendeeExistsFalse(){
			$this->assertFalse(checkAttendeeExists("Tommy", "Cat", "tommythecattesting123@gmail.com"));
		}

		function testCheckAttendeeExistsCloseMatchFalse(){
		    $this->assertFalse(checkAttendeeExists("Mary", "Jane", "mjane12398@yahoo.com"));
        }
	}