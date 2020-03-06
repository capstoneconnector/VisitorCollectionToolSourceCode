<?php
include_once "../php/getAttendeeInfo.php";

class GetAttendeeInfoTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
    public function setUp(){
    }
    public function tearDown(){
    }

    function testAttendeeFromAttributesSuccess(){
        $this->assertSame(getAttendeeFromAttributes("John", "Smith", "jsmith@gmail.com")->getEmail(), "jsmith@gmail.com");
    }
}