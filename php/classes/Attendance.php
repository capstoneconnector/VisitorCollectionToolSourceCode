<?php
require_once "../db/classes/DbClass.php";
require_once "../php/classes/Attendee.php";
require_once "../php/classes/Event.php";
require_once "Entry.php";


class Attendance extends Entry {
    private $attendeeId;
    private $eventId;
    private $isRegistered;
    private $isWalkIn;
    private $isAttended;

    public function __construct(int $attendeeId = 0, int $eventId = 0) {
        // idiot proofing

        $attendeeAndEventExist = true;

        if ($attendeeId && $eventId) {
            if (DbClass::readById(new Attendee(), [$attendeeId]) == false) {
                $attendeeAndEventExist = false;
                //echo "That attendee does not exist in the database!\n";
            }
            if (DbClass::readById(new Event(), [$eventId]) == false) {
                $attendeeAndEventExist = false;
                //echo "That event does not exist in the database!\n";
            }
        } else {
            $attendeeAndEventExist = false;
        }


        if ($attendeeAndEventExist) {
            $attendance = DbClass::readById($this, [$attendeeId, $eventId]);

            $this->attendeeId = $attendeeId;
            $this->eventId    = $eventId;

            if ($attendance) {
                $this->isRegistered = $attendance["Registered"];
                $this->isWalkIn     = $attendance["Walkin"];
                $this->isAttended   = $attendance["Attended"];
            } else {
                $this->isRegistered = true;
                $this->isWalkIn     = false;
                $this->isAttended   = false;
            }
        } else {
            $this->attendeeId   = 0;
            $this->eventId      = 0;
            $this->isRegistered = false;
            $this->isWalkIn     = false;
            $this->isAttended   = false;
        }
    }

    public function createNew($attendeeId, $eventId, $isRegistered, $isWalkIn, $isAttended){
        $this->attendeeId   = $attendeeId;
        $this->eventId      = $eventId;
        $this->isRegistered = $isRegistered;
        $this->isWalkIn     = $isWalkIn;
        $this->isAttended   = $isAttended;
    }

    public function save() : bool {
        if (DbClass::readById($this, [$this->attendeeId, $this->eventId])) {
            return DbClass::update($this);
        } else {
            return DbClass::insert($this);
        }
    }

    public function delete() {
        // TODO: Implement delete() method.
    }

    public function getAttendeeId() : int {
        return $this->attendeeId;
    }

    public function getEventId() : int {
        return $this->eventId;
    }

    public function getIsRegistered() : int {
        return $this->isRegistered;
    }

    public function getIsWalkIn() : int {
        return $this->isWalkIn;
    }

    public function getIsAttended() : int {
        return $this->isAttended;
    }

    public function setAttendeeId(int $attendeeId): void
    {
        $this->attendeeId = $attendeeId;
    }

    public function setEventId(int $eventId): void
    {
        $this->eventId = $eventId;
    }

    public function setIsRegistered(bool $isRegistered) : void {
        $this->isRegistered = $isRegistered;
    }

    public function setIsWalkIn(bool $isWalkIn) : void {
        $this->isWalkIn = $isWalkIn;
    }

    public function setIsAttended(bool $isAttended) : void {
        $this->isAttended = $isAttended;
    }
}