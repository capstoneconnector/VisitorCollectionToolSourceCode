<?php
require_once "../businessLogic/classes/Attendance.php";
require_once "../db/connect.php";


class AttendanceTest extends PHPUnit_Framework_TestCase {
    function setup() { }

    function teardown() { }

    function test_instantiation_with_both_ids_preexisting() {
        $attendance = new Attendance(10000, 999);
        $expected   = array
        (
            10000,
            999,
            1,
            0,
            0
        );
        $result     = array
        (
            $attendance->getAttendeeId(),
            $attendance->getEventId(),
            $attendance->getIsRegistered(),
            $attendance->getIsWalkIn(),
            $attendance->getIsAttended()
        );
        $this->assertSame($expected, $result);
    }

    // Bad attendee id means that no attendee exists with the given id in the database
    function test_creating_attendance_with_bad_attendee_id() {
        $attendance = new Attendance(1, 999);
        $expected   = array(
            0,
            0,
            0,
            0,
            0
        );
        $result     = array(
            $attendance->getAttendeeId(),
            $attendance->getEventId(),
            $attendance->getIsRegistered(),
            $attendance->getIsRegistered(),
            $attendance->getIsAttended()
        );
        $this->assertSame($expected, $result);
    }

    // Bad event id means that no event exists with the given id in the database
    function test_creating_attendance_with_bad_event_id() {
        $attendance = new Attendance(10000, 1);
        $expected   = array(
            0,
            0,
            0,
            0,
            0
        );
        $result     = array(
            $attendance->getAttendeeId(),
            $attendance->getEventId(),
            $attendance->getIsRegistered(),
            $attendance->getIsRegistered(),
            $attendance->getIsAttended()
        );
        $this->assertSame($expected, $result);
    }

    function test_saving_existing_entry() {
        $attendance = new Attendance(10006, 1000);
        $attendance->setIsAttended(true);
        $result = $attendance->save();

        newPDO()->exec("UPDATE attendance SET Attended=false WHERE Attendeeid=10006 AND Eventid=1000");

        $this->assertTrue($result);
    }

    function test_saving_new_entry() {
        $attendance = new Attendance(10000, 999);
        $attendance->setIsAttended(true);
        $result = $attendance->save();

        $attendance->setIsAttended(false); // reset database
        $attendance->save();

        $this->assertTrue($result);

    }
}