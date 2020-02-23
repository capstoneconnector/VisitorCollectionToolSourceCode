<?php
require_once "../../db/classes/DbClass.php";
require_once "../../php/classes/Attendee.php";

class DbClassTest extends PHPUnit_Framework_TestCase
{

    function testStaticUsageOfClass()
    {
        $attendee = new Attendee(10000);
        $this->assertNotNull(DbClass::in);
    }
}