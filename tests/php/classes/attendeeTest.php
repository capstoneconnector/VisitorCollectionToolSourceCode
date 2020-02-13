<?php
require_once "../../php/classes/Attendee.php";

class attendeeTest extends PHPUnit_Framework_TestCase
{
    private $fname;
    private $lname;
    private $email;
    private $phone;

    function createNewAttendeeTest()
    {
        $this->assertInstanceOf(Attendee::class, $attendee = new Attendee());
    }
}