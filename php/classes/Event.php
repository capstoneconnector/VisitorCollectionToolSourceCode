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
            $dbEvent = DbClass::readById($this, array($id));
            if ($id != $dbEvent["Eventid"])
            {
                trigger_error("There is no event with the given id");
            }

            if (!$dbEvent["Description"]) {$dbEvent["Description"] = "";}

            $this->create($dbEvent["Name"], $dbEvent["Date"], $dbEvent["Description"], $dbEvent["Ebid"]);
            $this->id = $id;
            $this->populateAttendeeList();
        } else {
            $this->create("", "");
        }
    }

    /**
     * @param $name
     * @param $date // TODO add regex before setting date. return an invalid formate exception if wrong format
     * @param $description
     * @param null $eventbriteId
     */

    public function createNew($id, $name, $date, $description, $eventbriteId=null)
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

    public function create(string $name, string $date, string $description="", int $eventbriteId=null)
    {
        $this->id = null;
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
        $this->eventbriteId = $eventbriteId;
    }

    public function save()
    {
        if ($this->id)
        {
            DbClass::update($this);
            foreach ($this->attendees as $attendee)
            {

            }
        }
    }

    public function addAttendee(Attendee $attendee)
    {
       array_push($this->attendees, $attendee);
    }

    /**
     * returns true if removal is successful. Returns false if there is no attendee to be removed. or the removal failed.
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
        foreach($dbAttendees as $dbAttendee)
        {
            $attendee = new Attendee($dbAttendee["Id"]);
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

    public function getDescription()
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

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setDate(string $date): void // TODO add regex checking for date format
    {
        $this->date = $date;
    }

    public function setDescription(String $description): void
    {
        $this->description = $description;
    }
}