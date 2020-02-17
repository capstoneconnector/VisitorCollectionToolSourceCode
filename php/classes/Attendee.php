<?php
require_once "../../db/dbInterface.php";


class Attendee
{
    private $id;
    private $fname;
    private $lname;
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
            $attendee = readAttendeeById($id);

            $this->id    = $id;
            $this->fname = $attendee["Fname"];
            $this->lname = $attendee["Lname"];
            $this->email = $attendee["Email"];
            $this->phone = $attendee["Phone"];
            return True;
        }
        return False;
    }

    /**
     * [WIP]
     * This is a factory function for Attendee
     * @param $id
     * @return bool
     */
    /*
    static public function fromId($id)
    {
        if ($id)
        {
            $attendee = readAttendeeById($id);

            $this->id    = $id;
            $this->fname = $attendee["Fname"];
            $this->lname = $attendee["Lname"];
            $this->email = $attendee["Email"];
            $this->phone = $attendee["Phone"];
            return self::__construct(fname, lname, email, phone);
        }
    }
    */
    public function createNew(string $fname, string $lname, string $email, string $phone=null)
    {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function save()
    {
        if ($attendee = readAttendeeById($this->getId()))
        {
            return updateAttendee($this->getId(), $this);
        } else {
            return insertAttendee($this);
        }
    }

    public function delete()
    {
        deleteAttendee($this->getId());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFname(): string
    {
        return $this->fname;
    }

    public function getLname(): string
    {
        return $this->lname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setFname($fname): void
    {
        $this->fname = $fname;
    }

    public function setLname($lname): void
    {
        $this->lname = $lname;
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
