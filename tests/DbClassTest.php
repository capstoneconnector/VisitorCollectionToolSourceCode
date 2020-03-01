<?php
require_once "../db/classes/DbClass.php";
require_once "../php/classes/Attendee.php";
require_once "../php/classes/Event.php";
require_once "../php/classes/Attendance.php";
require_once "../db/connect.php";

class DbClassTest extends PHPUnit_Framework_TestCase
{
    private $pdo;

    function setup()
    {
    }

    function teardown()
    {
        $this->pdo           = newPDO();
        $deleteTestAttendees = $this->pdo->prepare("DELETE FROM attendee WHERE Lname='Walton'");
        $deleteTestAttendees->execute();

        $deleteTestEvents = $this->pdo->prepare("DELETE FROM event WHERE Description='This is a description559'");
        $deleteTestEvents->execute();

        $updateAttendee = $this->pdo->prepare(
            "UPDATE attendee SET Fname='Jane', Lname='Doe', Phone='555-5555', Email='jdoe@bsu.edu' WHERE Id=10000"
        );
        $updateAttendee->execute();
    }

    function testReadById()
    {
        $expected = array
        (
            'Id'    => '10000',
            0       => '10000',
            'Fname' => 'Jane',
            1       => 'Jane',
            'Lname' => 'Doe',
            2       => 'Doe',
            'Phone' => '555-5555',
            3       => '555-5555',
            'Email' => 'jdoe@bsu.edu',
            4       => 'jdoe@bsu.edu',
            'Ebid'  => null,
            5       => null,
        );
        $result = DbClass::readById(new Attendee(), [10000]);

        $this->assertSame($expected, $result);
    }

    function testInsertAttendeeWithAllAttributesSet()
    {
        $attendee = new Attendee();
        $attendee->create("Jim", "Walton", "jimbob@gmail.com", "123-4567");
        $this->assertTrue(DbClass::insert($attendee));
    }

    function testInsertAttendeeWithoutPhoneNumberSet()
    {
        $attendee = new Attendee();
        $attendee->create("Olivia", "Walton", "oliviawalton@gmail.com");
        $this->assertTrue(DbClass::insert($attendee));
    }

    function testInsertingAttendeeSetsTheIdOfAttendee()
    {
        $attendee = new Attendee();
        $attendee->create("Mary", "Walton", "maryellen@gmail.com", "555-0001");
        DbClass::insert($attendee);
        $this->assertTrue(!empty($attendee->getId()));
    }

    function testInsertEvent()
    {
        $event = new Event();
        $event->create("Event Name", "2020-01-01", "This is a description559");
        $this->assertTrue(Dbclass::insert($event));

    }

    function testInsetEbEvent()
    {
        $event = new Event();
        $event->create("Eventbrite Event", "2020-02-01", "This is a description559", 123456789012);
        $this->assertTrue(DbClass::insert($event));
    }

    /*
     * the Attendance works within the project, but not as intended. this test will become relevant after iteration 4.
    function testInsertAttendance()
    {
        $attendance = new Attendance();
        $attendance->createNew(10000, 10000, 0, 0, 0);
        $this->assertTrue(DbClass::insert($attendance));
    }
    */

    function testUpdateAttendee()
    {
        $attendee = new Attendee(10000);
        $attendee->setFirstName("Albert");
        $attendee->setLastName("Ingalls");
        $attendee->setemail("alberingalls@good.mail");
        $attendee->setPhone("");
        $this->assertTrue(DbClass::update($attendee));
    }

    function testUpdateEntryThatDoesNotExist()
    {
        $attendee = new Attendee();
        $attendee->create("Mary", "Ingalls", "mn@good.year");
        $this->assertFalse(DbClass::update($attendee));
    }

    function testThatCreatingAnEventTheOldWayAndNewWayAreTheSame()
    {

    }
}