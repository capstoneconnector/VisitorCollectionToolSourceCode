<?php


class TableSummary
{
    private $tableName;
    private $primaryAttributes;
    private $secondaryAttributes;
    private $attributes;
    private $dbTableName;
    private $dbPrimaryAttributes;
    private $dbSecondaryAttributes;
    private $dbAttributes;

    private static $tableNames = array("Event", "Attendee", "Attendance");

    private function __construct(string $tableName,
                                array $primaryAttributes,
                                array $secondaryAttributes,
                                array $attributes,
                                string $dbTableName,
                                array $dbPrimaryAttributes,
                                array $dbSecondaryAttributes,
                                array $dbAttributes)
    {
        $this->tableName = $tableName;
        $this->primaryAttributes = $primaryAttributes;
        $this->secondaryAttributes = $secondaryAttributes;
        $this->attributes = $attributes;
        $this->dbTableName = $dbTableName;
        $this->dbPrimaryAttributes = $dbPrimaryAttributes;
        $this->dbSecondaryAttributes = $dbSecondaryAttributes;
        $this->dbAttributes = $dbAttributes;
    }

    public static function getTableSummaries() : array
    {
        $summaries = array();
        foreach (self::$tableNames as $name)
        {
            $funcName = "get{$name}Summary";
            $summaries[$name] = self::$funcName();
        }

        return $summaries;
    }

    public static function getAttendeeSummary() : TableSummary
    {
        // class defined names and attributes
        $tableName           = "Attendee";
        $primaryAttributes   = array("id");
        $secondaryAttributes = array();
        $attributes          = array("id", "firstName", "lastName", "phone", "email", "eventbriteId", "gender");

        // database defined names and attributes
        $dbTableName           = "attendee";
        $dbPrimaryAttributes   = array("Id");
        $dbSecondaryAttributes = array();
        $dbAttributes          = array("Id", "Fname", "Lname", "Phone", "Email", "Ebid", "Gender");

        return new TableSummary
        (
            $tableName,
            $primaryAttributes,
            $secondaryAttributes,
            $attributes,
            $dbTableName,
            $dbPrimaryAttributes,
            $dbSecondaryAttributes,
            $dbAttributes
        );
    }

    public static function getEventSummary() : TableSummary
    {
        // class defined names and attributes
        $tableName           = "Event";
        $primaryAttributes   = array("id");
        $secondaryAttributes = array();
        $attributes          = array("id", "name", "date", "description", "eventbriteId");

        // database defined names and attributes
        $dbTableName           = "event";
        $dbPrimaryAttributes   = array("Eventid");
        $dbSecondaryAttributes = array();
        $dbAttributes          = array("Eventid", "Name", "Date", "Description", "Ebid");

        return new TableSummary
        (
            $tableName,
            $primaryAttributes,
            $secondaryAttributes,
            $attributes,
            $dbTableName,
            $dbPrimaryAttributes,
            $dbSecondaryAttributes,
            $dbAttributes
        );
    }

    public static function getAttendanceSummary()
    {
        // class defined names and attributes
        $tableName           = "Attendance";
        $primaryAttributes   = array("attendeeId", "eventId");
        $secondaryAttributes = array();
        $attributes          = array("attendeeId", "eventId", "isRegistered", "isWalkIn", "isAttended");

        // database defined names and attributes
        $dbTableName           = "attendance";
        $dbPrimaryAttributes   = array("Attendeeid", "Eventid");
        $dbSecondaryAttributes = array();
        $dbAttributes          = array("Attendeeid", "Eventid", "Registered", "Walkin", "Attended");

        return new TableSummary
        (
            $tableName,
            $primaryAttributes,
            $secondaryAttributes,
            $attributes,
            $dbTableName,
            $dbPrimaryAttributes,
            $dbSecondaryAttributes,
            $dbAttributes
        );
    }

    public function getTableNames(): string
    {
        return $this->tableName;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getPrimaryAttributes(): array
    {
        return $this->primaryAttributes;
    }

    public function getSecondaryAttributes(): array
    {
        return $this->secondaryAttributes;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getDbTableName(): string
    {
        return $this->dbTableName;
    }

    public function getDbPrimaryAttributes(): array
    {
        return $this->dbPrimaryAttributes;
    }

    public function getDbSecondaryAttributes(): array
    {
        return $this->dbSecondaryAttributes;
    }

    public function getDbAttributes(): array
    {
        return $this->dbAttributes;
    }
}