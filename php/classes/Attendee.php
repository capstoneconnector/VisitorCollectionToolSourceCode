<?php
require_once "Entry.php";
//require_once "../../db/classes/DbClass.php";

class Attendee extends Entry
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $phone;

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
            $ids = array($id);
            $attendee = DbClass::readById($this, $ids);

            $this->id        = $id;
            $this->firstName = $attendee["Fname"];
            $this->lastName  = $attendee["Lname"];
            $this->email     = $attendee["Email"];
            $this->phone     = $attendee["Phone"];
        }
    }

    public function createNew($id, $fname, $lname, $email, $phone=null)
    {
        $this->id = $id;
        $this->firstName = $fname;
        $this->lastName = $lname;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function create(string $firstName, string $lastName, string $email, string $phone="")
    {
        $this->id = null;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
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
}