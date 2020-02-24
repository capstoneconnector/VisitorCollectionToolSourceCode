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

    private static $tableNames = array("Event", "Attendee");

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
        $tableName              = "Attendee";
        $primaryAttributes      = array("id");
        $secondaryAttributes    = array("email");
        $attributes             = array("id", "firstName", "lastName", "phone", "email");

        // database defined names and attributes
        $dbTableName            = "attendee";
        $dbPrimaryAttributes    = array("Id");
        $dbSecondaryAttributes  = array("Email");
        $dbAttributes           = array("Id", "Fname", "Lname", "Phone", "Email");

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
        $tableName = "Event";
        $primaryAttributes = array("id");
        $secondaryAttributes = array("eventbriteId");
        $attributes = array("id", "name", "date", "description", "eventbriteId");

        // database defined names and attributes
        $dbTableName = "event";
        $dbPrimaryAttributes = array("Eventid");
        $dbSecondaryAttributes = array("Ebid");
        $dbAttributes = array("Eventid", "Name", "Date", "Description", "Ebid");

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

    public function getDbAttributes(): array
    {
        return $this->dbAttributes;
    }
}