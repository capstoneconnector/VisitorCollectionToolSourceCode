<?php
require_once "Entry.php";

class Attendee extends Entry
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $phone;
    private $eventbriteId;

    /**
     * If $id is provided, then Attendee is created with information from DB
     * If $id is not provided then an empty Attendee object is created with no values set. Use createNew() to create a new Attendee with new parameters
     *
     * Attendee constructor.
     * @param int $id
     */
    public function __construct(int $id=0)
    {
        if ($id)
        {
            $attendee = DbClass::readById($this, array($id));

            if ($id != $attendee["Id"])
            {
                echo "There is no attendee with the given id\n";
                trigger_error("There is no attendee with the given id");
            }

            $this->id           = $id;
            $this->firstName    = $attendee["Fname"];
            $this->lastName     = $attendee["Lname"];
            $this->email        = $attendee["Email"];

            if (!empty($attendee["Phone"])) {
                $this->phone = $attendee["Phone"];
            } else {
                $this->phone = "";
            }

            if (!empty($attendee["Ebid"])) {
                $this->eventbriteId = $attendee["Ebid"];
            } else {
                $this->eventbriteId = 0;
            }
        }
    }

    public function createNew($id, $fname, $lname, $email, $phone=null)
    {
        $this->id        = $id;
        $this->firstName = $fname;
        $this->lastName  = $lname;
        $this->email     = strtolower($email);
        $this->phone     = $phone;
    }

    public function create(string $firstName, string $lastName, string $email, string $phone = "", int $eventbriteId = 0) {
        $this->id           = null;
        $this->firstName    = $firstName;
        $this->lastName     = $lastName;
        $this->email        = strtolower($email);
        $this->phone        = $phone;
        $this->eventbriteId = $eventbriteId;
    }

    public function save() : bool {
        if ($this->id) {
            return DbClass::update($this);
        } else {
            return DbClass::insert($this);
        }
    }

    public function delete() {
        // TODO: Implement delete() method.
    }

    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    public function getEventbriteId() {
        return $this->eventbriteId ? $this->eventbriteId : null;
    }
}