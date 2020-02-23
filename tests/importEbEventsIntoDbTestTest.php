<?php
include_once "../php/ebinterface.php";
require_once "../php/getEventInfo.php";

class importEbEventIntoDbTest extends PHPUnit_Framework_TestCase { //Run this file with phpunit command from command line

    function testRunImportEvents()
    {
		$oAuthToken = "COKR3D7YQAPZM2GWLOTL";
		$this->assertTrue(importEbEvents($oAuthToken));

	}

	function testNewEqualsOld()
    {
        $eventId = 10000;

        //$this->assertSame(true, true);
        //$this->assertEquals(getEvent($eventId), getEventNew($eventId));
    }


}