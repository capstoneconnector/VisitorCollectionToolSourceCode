<?php


class Attendance
{
    private $attendeeId;
    private $eventId;
    private $registered;
    private $walkIn;
    private $attended;



    public function __construct(int $attendeeId,
                                   int $eventId,
                                   bool $registered,
                                   bool $walkin,
                                   bool $attended)
    {
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

    public function save()
    {
        return 0;
    }

    public function delete()
    {

    }

    public function getAttendeeId()
    {
        return $this->attendeeId;
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    public function getRegistered()
    {
        return $this->registered;
    }

    public function getWalkIn()
    {
        return $this->walkIn;
    }

    public function getAttended()
    {
        return $this->attended;
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