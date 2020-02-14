<?php
require_once "../../db/dbInterface.php";

class Event
{
    private $name;
    private $date;
    private $description;
    private $id;
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
            $event = readEventById($id);

            $this->id = $id;
            $this->name = $event["Name"];
            $this->date = $event["date"];
            $this->description = $event["Description"];
            $this->eventbriteId = $event["ebid"];
        }
    }

    /**
     *
     * @param $name
     * @param $date // TODO add regex before setting date. return an invalid formate exception if wrong format
     * @param $description
     * @param null $eventbriteId
     */

    public function createNew($name, $date, $description, $eventbriteId=null)
    {
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
        deleteEvent($this->getId()); // TODO finish implementation for deleteEvent() in db/dbInterface.php
    }

    /**
     * returns the number of attendees in the event after adding the new attendee
     */
    public function addAttendee(Attendee $attendee) : int
    {
        return array_push($this->attendees, $attendee);
    }

    /**
     * Returns the removed attendee
     * Returns an Exception if the attendee is not in the array
     *
     * @param Attendee $attendee
     * @return array|Exception
     */
    public function removeAttendee(Attendee $attendee)
    {
        $index = array_search($attendee, $this->attendees);
        if ($index)
        {
            return array_splice($this->attendees, $index);
        } else {
            return new Exception(); // TODO more descriptive exception for attendee not it array
        }
    }

    public function getName(): string
    {
        return new $this->name;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return new $this->date;
    }

    public function getDescription(): String
    {
        return new $this->description;
    }

    public function getId(): int
    {
        return new $this->id;
    }

    public function getEventbriteId(): int
    {
        return new $this->eventbriteId;
    }

    /**
     * @return array
     */
    public function getAttendees(): array
    {
        return new $this->attendees;
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