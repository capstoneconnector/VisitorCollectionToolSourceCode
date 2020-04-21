<?php
require_once "../businessLogic/classes/Event.php";
require_once "../businessLogic/classes/Attendee.php";


class EventTest extends PHPUnit_Framework_TestCase {
    public function testCreatingAnEventWithoutParametersCreatesEmptyEvent() {
        $event = new Event();

        //if any varyible is set to a value when an empty event is called, then $varExists will become true.
        $varExists = false;
        if ($event->getId())            {$varExists = true;}
        if ($event->getName())          {$varExists = true;}
        if ($event->getDate())          {$varExists = true;}
        if ($event->getDescription())   {$varExists = true;}
        if ($event->getEventbriteId())  {$varExists = true;}
        if ($event->getAttendees())     {$varExists = true;}
        $this->assertFalse($varExists);
    }

    public function testCreatingAnEventByFrom()
    {
        $event = new Event();
        $event->create("Automated Test Event", "2100-01-01", "This is only a test event");

        $expected = array
        (
            null,
            "Automated Test Event",
            "2100-01-01",
            "This is only a test event",
            null,
            array()
        );

        $result = array
        (
            $event->getId(),
            $event->getName(),
            $event->getDate(),
            $event->getDescription(),
            $event->getEventbriteId(),
            $event->getAttendees(),
        );
        $this->assertSame($expected, $result);
    }

    public function testCreatingEventByID()
    {
        $id = 999;
        $event = new Event($id);

        $expected = Array (
            0 => 999,
            1 => 'Test Event',
            2 => '',
            3 => '2030-04-01',
            4 => null,
        );

        $result = array
        (
            $event->getId(),
            $event->getName(),
            $event->getDescription(),
            $event->getDate(),
            $event->getEventbriteId(),
        );
        $this->assertSame($expected, $result);
    }

    //public function test
}