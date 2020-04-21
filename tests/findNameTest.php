<?php
include_once "../backend/findName.php";

class FindNameTest extends PHPUnit_Framework_TestCase { //Run this file with phpunit command from command line
    private $event;

    public function setUp() {
        $this->event = new Event();
        $this->event->createNew(999, "Test Event", "2030-04-01", "");
        $this->event->populateAttendeeList();
    }

    public function tearDown() {
    }

		function testFindNameOneResult(){
			$this->assertSame(findName("John Smith", $this->event)[0]->getEmail(), "jsmith@gmail.com");
	
		}

		function testFindNameMoreThanOneResult(){
			$this->assertSame(findName("Bob Jones", $this->event)[1]->getEmail(), "bjones2@gmail.com");
		}

		function testFindNameNoResultsWhenAlreadyRegistered(){
			$this->assertEmpty(findName("Mary Jane", $this->event));
		}

		function testFindNameNoResults(){
			$this->assertEmpty(findName("John Doe", $this->event));
		}
	}