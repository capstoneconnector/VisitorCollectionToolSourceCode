<?php
require_once "../db/classes/DbClass.php";
require_once "../php/classes/Attendee.php";
require_once "../php/classes/Event.php";
require_once "../php/classes/Attendance.php";
require_once "../db/connect.php";

class DbClassTest extends PHPUnit_Framework_TestCase
{
    function setup()
    {
    }

    function teardown() { }

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
            'Ebid'  => null,
            5       => null,
        );
        $result   = DbClass::readById(new Attendee(), [10000]);

        $this->assertSame($expected, $result);
    }

    function testReadAttendanceById() {
        $expected = array(
            'Attendeeid' => '10004',
            0            => '10004',
            'Eventid'    => '1000',
            1            => '1000',
            'Registered' => '1',
            2            => '1',
            'Walkin'     => '0',
            3            => '0',
            'Attended'   => '1',
            4            => '1'
        );
        $result   = DbClass::readById(new Attendance(), [10004, 1000]);
        $this->assertSame($expected, $result);
    }

    function testInsertAttendeeWithAllAttributesSet() {
        $attendee = new Attendee();
        $attendee->create("Jim", "Walton", "jimbob@gmail.com", "123-4567");
        $result = DbClass::insert($attendee);
        newPDO()->exec("DELETE FROM attendee WHERE Lname='Walton'"); // reset database
        $this->assertTrue($result);
    }

    function testInsertingAttendeeSetsTheIdOfAttendee() {
        $attendee = new Attendee();
        $attendee->create("Mary", "Walton", "maryellen@gmail.com", "555-0001");
        DbClass::insert($attendee);
        $result = !empty($attendee->getId());
        newPDO()->exec("DELETE FROM attendee WHERE Lname='Walton'"); // reset database
        $this->assertTrue($result);
    }

    function testInsertEvent() {
        $event = new Event();
        $event->create("Event Name", "2020-01-01", "This is a description559");
        $result = Dbclass::insert($event);
        newPDO()->exec("DELETE FROM event WHERE Description='This is a description559'"); // reset database
        $this->assertTrue($result);

    }

    function testInsetEbEvent() {
        $event = new Event();
        $event->create("Eventbrite Event", "2020-02-01", "This is a description559", 123456789012);
        $result = DbClass::insert($event);
        newPDO()->exec("DELETE FROM event WHERE Ebid=123456789012"); // reset database
        $this->assertTrue($result);
    }

    function testInsertAttendance() {
        $attendance = new Attendance(10001, 999);
        $result     = DbClass::insert($attendance);
        newPDO()->exec("DELETE FROM attendance WHERE Attendeeid=10001 AND Eventid=999"); // reset database
        $this->assertTrue($result);
    }

    function testUpdateAttendee() {
        $attendee = new Attendee(10003);
        $attendee->setFirstName("Albert");
        $attendee->setLastName("Ingalls");
        $attendee->setemail("alberingalls@good.mail");
        $attendee->setPhone("");
        $result = DbClass::update($attendee);
        newPDO()->exec("UPDATE attendee 
                        SET Fname='Bob', Lname='Jones', Email='bjones2@gmail.com', Phone='555-5555' 
                        WHERE Id=10003"
        ); // reset database
        $this->assertTrue($result);
    }

    function testUpdateEntryThatDoesNotExist()
    {
        $attendee = new Attendee();
        $attendee->create("Mary", "Ingalls", "mn@good.year");
        $this->assertFalse(DbClass::update($attendee));
    }

}