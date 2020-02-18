<?php


class Attendance extends Entry
{
    const TABLE_NAME = "Attendance";
    const KEY_ATTRIBUTES = array("attendeeId", "eventId");
    const ATTRIBUTE_NAMES = array("attendeeId", "eventId", "registered", "walkIn", "attended");
    const DB_KEY_ATTRIBUTES = array("Attendeeid", "Eventid");
    const DB_ATTRIBUTE_NAMES = array("Attendeeid", "Eventid", "Registered", "Walkin", "Attended");

    private $attendeeId;
    private $eventId;
    private $registered;
    private $walkIn;
    private $attended;

    private function __constructor(int $attendeeId,
                                   int $eventId,
                                   bool $registered,
                                   bool $walkin,
                                   bool $attended)
    {
        parent::__construct(self::TABLE_NAME,
                            self::KEY_ATTRIBUTES,
                            self::ATTRIBUTE_NAMES,
                            self::DB_KEY_ATTRIBUTES,
                            self::DB_ATTRIBUTE_NAMES);

        $this->attendeeId = $attendeeId;
        $this->eventId = $eventId;
        $this->registered = $registered;
        $this->walkIn = $walkin;
        $this->attended = $attended;
    }

    public static function byId(int $id)
    {

    }

    public static function byForm(int $attendeeId,
                                  int $eventId,
                                  bool $registered=true,
                                  bool $walkin=false,
                                  bool $attended=false)
    {
        return 0;
    }

    public function delete()
    {

    }

    public function getAttendeeId() : int
    {
        return new $this->attendeeId;
    }

    public function getEventId() : int
    {
        return new $this->eventId;
    }

    public function getRegistered() : bool
    {
        return new $this->registered;
    }

    public function getWalkIn() : bool
    {
        return new $this->walkIn;
    }

    public function getAttended() : bool
    {
        return new $this->attended;
    }

    public function setAttendeeId(int $attendeeId): void
    {
        $this->attendeeId = $attendeeId;
    }

    public function setEventId(int $eventId): void
    {
        $this->eventId = $eventId;
    }

    public function setRegistered(bool $registered): void
    {
        $this->registered = $registered;
    }

    public function setWalkIn(bool $walkIn): void
    {
        $this->walkIn = $walkIn;
    }

    public function setAttended(bool $attended): void
    {
        $this->attended = $attended;
    }
}