<?php
require_once "../../db/dbInterface.php";

class Event
{
    private string $name;
    private $date;
    private String $description;
    private int $id;
    private int $eventbriteId;
    private array $attendees = array();

    /**
     * @return string
     */
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

    /**
     * @return String
     */
    public function getDescription(): String
    {
        return new $this->description;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return new $this->id;
    }

    /**
     * @return int
     */
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


    /**
     * Event constructor.
     * @param $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;

        $event = getEventById($id);

        $this->name = $event["Name"];
        $this->date = $event["date"];
        $this->description = $event["Description"];
        $this->eventbriteId = $event["ebid"];

    }

    public function save()
    {

    }

    /**
     * returns the number of attendees in the event after adding the new attendee
     */
    public function addAttendee(int $attendeeId) : int {
        return array_push($this->attendees, new Attendee($attendeeId));
    }

    public function rename(string $name)
    {
        $this->name = $name;
    }
}