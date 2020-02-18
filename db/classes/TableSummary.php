<?php


class TableSummary
{
    private string $tableName;
    private array $keyAttributes;
    private array $attributes;
    private string $dbTableName;
    private array $dbKeyAttributes;
    private array $dbAttributes;

    private static array $tableNames = array("Event", "Attendee");

    private function __construct(string $tableName,
                                array $keyAttributes,
                                array $attributes,
                                string $dbTableName,
                                array $dbKeyAttributes,
                                array $dbAttributes)
    {
        $this->tableName = $tableName;
        $this->keyAttributes = $keyAttributes;
        $this->attributes = $attributes;
        $this->dbTableName = $dbTableName;
        $this->dbKeyAttributes = $dbKeyAttributes;
        $this->dbAttributes = $dbAttributes;

        array_push(self::$tableNames, $this->tableName);
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
        $tableName = "Attendee";
        $keyAttributes = array("id");
        $attributes = array("id", "firstName", "lastName", "email", "phone");
        $dbTableName = "attendee";
        $dbKeyAttributes = array("Id");
        $dbAttributes = array("Id", "Fname", "Lname", "Phone", "Email");

        return new TableSummary
        (
            $tableName,
            $keyAttributes,
            $attributes,
            $dbTableName,
            $dbKeyAttributes,
            $dbAttributes
        );
    }

    public static function getEventSummery() : TableSummary
    {
        $tableName = "Event";
        $keyAttributes = array("id");
        $attributes = array("id", "name", "date", "description", "eventbriteId");
        $dbTableName = "event";
        $dbKeyAttributes = array("Eventid");
        $dbAttributes = array("Eventid", "Name", "Date", "Description", "Ebid");

        return new TableSummary
        (
            $tableName,
            $keyAttributes,
            $attributes,
            $dbTableName,
            $dbKeyAttributes,
            $dbAttributes
        );
    }
}