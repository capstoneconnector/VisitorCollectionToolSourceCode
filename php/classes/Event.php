<?php
require_once "Entry.php";
//require_once "../db/classes/DbClass.php";
//require_once "../php/classes/Attendee.php";

require_once "C:/xampp/htdocs/VisitorCollectionToolSourceCode/db/classes/DbClass.php";
require_once "C:/xampp/htdocs/VisitorCollectionToolSourceCode/php/classes/Attendee.php";


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
            $dbEvent = DbClass::getEventByID($id);
            $this->createNew($dbEvent["Name"], $dbEvent["Date"], $dbEvent["Description"], $dbEvent["Ebid"]);
            $this->id = $id;
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

    public function create(string $name, string $date, string $description="", int $eventbriteId=null)
    {
        $this->id = null;
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
        $this->eventbriteId = $eventbriteId;
    }

    public function addAttendee(Attendee $attendee)
    {
       array_push($this->attendees, $attendee);
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
    public function setDate(string $date): void // TODO add regex checking for date format
    {
        $this->date = $date;
    }

    public function setDescription(String $description): void
    {
        $this->description = $description;
    }
}