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
            $attendee = getAttendeeById($id);

            $this->id    = $id;
            $this->fname = $attendee["Fname"];
            $this->lname = $attendee["Lname"];
            $this->email = $attendee["Email"];
            $this->phone = $attendee["Phone"];
            return True;
        }
        return False;
    }

    public function createNew(string $fname, string $lname, string $email, string $phone=null)
    {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function save()
    {
        if ($id)
        {

        }
        return insertAttendee($this);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFname(): string
    {
        return $this->fname;
    }

    /**
     * @return string
     */
    public function getLname(): string
    {
        return $this->lname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

}
