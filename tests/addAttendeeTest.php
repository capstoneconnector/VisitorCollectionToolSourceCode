<?php
include_once "../db/dbInterface.php";
include_once "../db/connect.php";
include_once "../php/classes/Attendee.php";

class AddAttendeeTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
    public function setUp() {
        $this->eventid = 999;
        $this->attendee = new Attendee();
        $this->attendee->createNew("Jane", "Patterson", "jp@gmail.org", "123456789");
    }

    public function tearDown() {
        $pdo = newPDO();
        $stmt = $pdo->prepare("DELETE FROM attendee WHERE Eventid = 999 AND Email = 'jperson@gmail.com'");
        $stmt->execute();
    }

    function testAddAttendeeSuccess() {
        $this->assertTrue(registerUser("James", "Person", "jperson@gmail.com", $this->eventid));
    }

    function testInsertAttendee() {
        $this->assertTrue(insertAttendee($this->attendee));
    }
}