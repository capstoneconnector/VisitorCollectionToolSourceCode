<?php
require_once "Entry.php";
require_once "../db/classes/DbClass.php";
require_once "../php/classes/Attendee.php";

class Event extends Entry
{
    private $id;
    private $name;
    private $date;
    private $description;
    private $eventbriteId;
    private $attendees = array();

    /**
     * Event constructor.
     * @param $id
     */
    public function __construct(int $id=0)
    {
        if ($id)
        {
            $this->id = $id;
            $dbEvent = DbClass::getEventByID($id);

            $this->name = $dbEvent["Name"];
            $this->date = $dbEvent["Date"];
            $this->description = $dbEvent["Description"];
            if (!isset($dbEvent["Ebid"])) {
                $this->eventbriteId = $dbEvent["Ebid"];
            }
            $this->populateAttendeeList();
        }
    }

    /**
     *
     * @param $name
     * @param $date // TODO add regex before setting date. return an invalid formate exception if wrong format
     * @param $description
     * @param null $eventbriteId
     */

    public function createNew($id, string $name, string $date, string $description, int $eventbriteId=null)
    {
        //unset($this->id);
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
        if (!empty($eventbriteId)) {
            $this->eventbriteId = $eventbriteId;
        }
    }

    public function save()
    {
        if (readEventById($this->getId()))
        {
            updateEvent($this->getId(), $this);
        } else {
            insertEvent($this);
        }
    }

    public function delete() // TODO Should this also delete all of the attendance records associated with this event?
    {
        //deleteEvent($this->getId()); // TODO finish implementation for deleteEvent() in db/dbInterface.php
    }

    /**
     * returns the number of attendees in the event after adding the new attendee
     */
    public function addAttendee(Attendee $attendee) : int
    {
        return array_push($this->attendees, $attendee);
    }

    /**
     * returns true if removal is sucessful. Returns false if there is no attendee to be removed. or the removal failed.
     *
     * @param Attendee $attendee
     * @return bool
     */
    public function removeAttendee(Attendee $attendee)
    {
        $index = array_search($attendee, $this->attendees);
        if ($index)
        {
            $this->attendees = array_splice($this->attendees, $index, $index);
            return true;
        } else {
            return false;
        }
    }

    public function populateAttendeeList()
    {
        $attendees = [];
        $dbAttendees = DbClass::getAttendeesForEvent($this->id);
        foreach($dbAttendees as $row)
        {
            $attendee = new Attendee($row["Id"]);
            $attendee->createNew($row["Id"], $row["Fname"], $row["Lname"], $row["Email"], $row["Phone"]);
            array_push($attendees, $attendee);
        }
        $this->attendees = $attendees;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    public function getDescription(): String
    {
        return $this->description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEventbriteId()
    {
        return $this->eventbriteId;
    }

    /**
     * @return array
     */
    public function getAttendees(): array
    {
        return $this->attendees;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void // TODO add regex checking for date format
    {
        $this->date = $date;
    }

    public function setDescription(String $description): void
    {
        $this->description = $description;
    }
}