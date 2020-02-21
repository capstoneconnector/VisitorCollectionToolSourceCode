<?php
require_once "../db/connect.php";
require_once "../db/classes/DbManagerInterface.php";

class DbClass implements DbManagerInterface
{
    private $tableSummaries;

    public function __construct()
    {
        $this->tableSummaries = TableSummary::getTableSummaries();
    }

    /**
     * Pulls an entry from a table using the id(s) of the entry and returns an array
     *
     * @param int $ids
     * The row entry of the corresponding id(s)
     * @return array
     * The full row data of the corresponding id(s) pulled from the db of the class with corresponding name
     */
    function readById(array $ids)
    {
        //$conditional = join(", ", $this->getColumnEqualsValuePair($this->keyAttributes));
        $conditional = "";
        for ($index=0; $index<count($ids); $index++)
            {
                $conditional .= $this->keyAttributes[$index] . "=" . $ids[$index] . " ";
            }
        $statement = newPDO()->prepare("SELECT * FROM {$this->tableName} WHERE {$conditional}");

        $tableResult = array();
        if($statement->execute())
        {
            while($row = $statement->fetch())
            {
                array_push($tableResult, $row);
            }
            return $tableResult;
        } else {
            trigger_error("Selection statement failed. Could not retrieve entry from DB");
        }
    }

    /**
     * Inserts a new entry into the table corresponding to the name of the class using the specified attributes in that
     * class
     *
     * @param int $id
     * refers to the entry of the corresponding id
     * @param DbClass $dbClass
     * @return bool
     * returns true if the insertion was successful; otherwise returns false.
     */
    function insert()
    {
        $columns = join(", ", $this->attributeDbNames);
        $values = join(", ", $this->getValuesOfAttributes($this->attributeNames));
        $statement = newPDO()->prepare("INSERT INTO {$this->tableName}({$columns}) VALUES ({$values})");
        return $statement->execute();
    }

    function insertNew(Entry $entry)
    {
        $tableType = $this->tableSummaries[get_class($entry)];

        $columns = join(", ", $tableType["dbAttributes"]);
        $values = join(", ", $this->getValuesOfAttributes($entry, $tableType["attributes"]));

        $statement = newPDO()->prepare("INSERT INTO {$tableType["dbTableName"]}({$columns}) VALUES ({$values})");

        return $statement->execute();
    }

    /**
     * Resets all attributes in the DB to the current attribute values represented in the class. The entry must exist
     * in the DB to update the entry.
     * Throws error if the $keyAttribute is not set; indicating that there is no entry in the DB.
     * @return bool
     * returns true if the update is successful; otherwise returns false.
     */
    function update()
    {
        if (!empty($this->getValueOfAttribute($this->keyAttribute)))
        {
            $columnValuePair = array();
            foreach ($this->attributeNames as $attrName) {
                array_push($columnValuePair, $attrName . "=" . $this->getValueOfAttribute($attrName));
            }

            $values = join(", ", $columnValuePair);
            $conditional = $this->DbKeyAttributes . "=" . $this->getValuesOfAttributes($this->keyAttributes);
            $statement = newPDO()->prepare("UPDATE {$this->tableName} SET {$values} WHERE {$conditional}");
            return $statement->execute();
        } else {
            trigger_error("Entry does not exist!");
        }
    }

    function updateNew()
    {
        if (!empty($this->getValueOfAttribute($this->keyAttributes)))
        {
            $columnValuePair = $this->getColumnEqualsValuePair($this->attributeNames);

            $values = join(", ", $columnValuePair);
            $conditional = $this->DbKeyAttributes . "=" . $this->getValuesOfAttributes($this->keyAttributes);
            $statement = newPDO()->prepare("UPDATE {$this->tableName} SET {$values} WHERE {$conditional}");
            return $statement->execute();
        } else {
            trigger_error("Entry does not exist!");
        }
    }

    function delete()
    {
        // TODO: Implement delete() method.
    }

    function save()
    {
        if (!empty($this->getValuesOfAttributes($this->keyAttributes)))
        {
            $this->update();
        } else {
            $this->insert();
            // TODO set the subclass id(s) to the newly created entry id(s)
            //see https://www.w3schools.com/php/php_mysql_insert_lastid.asp
        }
    }

    /**
     * Takes a class defined attribute <name> and returns get<name>() for that attribute in that class.
     * Example: an attribute named "email" will return getEmail().
     *
     * @param string $attributeName
     * @return mixed
     */
    private function getValueOfAttribute(Entry $entry, string $attributeName)
    {
        $attributeFunctionName = "get".ucfirst($attributeName);
        return $entry->$attributeFunctionName();
    }

    /**
     * Takes an array of strings where each string is a class defined attribute <name> and returns an array of the
     * result of the get<name>() function declared in that class
     * @param array $attributeNames
     * @return array
     */
    private function getValuesOfAttributes(Entry $entry, array $attributeNames)
    {
        $attributeValues = array();
        foreach ($attributeNames as $attrName)
        {
            array_push($attributeValues, $this->getValueOfAttribute($entry, $attrName));
        }

        return $attributeValues;
    }

    private function getColumnEqualsValuePair(array $attributeNames)
    {
        $columnValuePair = array();
        foreach ($attributeNames as $attrName) {
            array_push($columnValuePair, $attrName . "=" . $this->getValueOfAttribute($attrName));
        }

        return $columnValuePair;
    }

    static function getAllEventsAfterCurrentDate(){
        $statement = newPDO()->prepare("SELECT * FROM event WHERE Date >= DATE(NOW())"); //Fetch all events
        $info = array();
        if($statement->execute()) {
            while($row = $statement->fetch()) {
                array_push($info, $row);
            }
        }
        return $info;
    }

    static function getAttendeesForEvent($eventid){
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT Id, Fname, Lname, Email, Phone FROM attendee, attendance, event WHERE event.Eventid = attendance.Eventid AND attendee.Id = attendance.Attendeeid AND event.Eventid = ?");
        $statement->bindParam(1, $eventid);
        $info = array();
        if($statement->execute()) {
            while($row = $statement->fetch()) {
                array_push($info, $row);
            }
        }
        return $info;
    }

    static function getEventByID($id) {
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT * FROM event WHERE Eventid=?"); //Fetch specific event by id
        $statement->bindParam(1, $id);
        $statement->execute();
        return $info = $statement->fetch();
    }

    static function checkAttendanceByID($attendeeID, $eventID){
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT COUNT(*) AS num FROM attendance WHERE Attendeeid = ? AND Eventid = ? AND Attended = TRUE"); //Find all attendees with similar first and last names entered
        $statement->bindParam(1, $attendeeID);
        $statement->bindParam(2, $eventID);
        if($statement->execute()){
            $result = $statement->fetch();
            if($result['num'] > 0){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
    }

    static function setAttendedTrue($attendeeID, $eventID){
        $pdo = newPDO();
        $statement = $pdo->prepare("UPDATE attendance SET Attended = TRUE WHERE Eventid = ? AND Attendeeid = ?");
        $statement->bindParam(1, $eventID);
        $statement->bindParam(2, $attendeeID);
        if($statement->execute()){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}