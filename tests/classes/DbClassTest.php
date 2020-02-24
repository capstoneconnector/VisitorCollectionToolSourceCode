<?php
require_once "../../db/classes/DbClass.php";
require_once "../../php/classes/Attendee.php";
require_once "../../php/classes/Event.php";
require_once "../../db/connect.php";

class DbClassTest extends PHPUnit_Framework_TestCase
{

    function testReadById()
    {
        $expected = array
        (
            'Id'    => '10000',
            0       => '10000',
            'Fname' => 'Bob',
            1       => 'Bob',
            'Lname' => 'Jones',
            2       => 'Jones',
            'Phone' => '555-5555',
            3       => '555-5555',
            'Email' => 'bjones@gmail.com',
            4       => 'bjones@gmail.com',
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
        $attendee->create("Mary", "Walton", "maryellen@gmail.com");
        DbClass::insert($attendee);
        $this->assertTrue(!empty($attendee->getId()));
    }

    function testInsertEvent()
    {
        $event = new Event();
        $event->create("Event Name", "2020-01-01", "This is a description");
        $this->assertTrue(Dbclass::insert($event));

    }

    function testInsetEbEvent()
    {
        $event = new Event();
        $event->create("Eventbrite Event", "2020-02-01", "the eventbrite description", 86470394277);
        $this->assertTrue(DbClass::insert($event));
    }

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
}