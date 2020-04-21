<?php
include_once "../backend/createAttendee.php";

class CreateAttendeeTest extends PHPUnit_Framework_TestCase { //Run this file with phpunit command from command line
    public function setUp() {
    }

    public function tearDown() {
        $pdo  = new PDO('mysql:host=localhost;dbname=icdb', "root", "");
        $stmt = $pdo->prepare("DELETE FROM attendee WHERE Fname = 'James' AND Lname = 'Person'  AND Email = 'jperson5678@gmail.com'");
        $stmt->execute();
    }

		function testAddAttendeeSuccess(){
			$this->assertSame(createAttendee("James", "Person", "555-5555", "jperson5678@gmail.com")->getFirstName(), "James");
		}
	}