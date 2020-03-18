<?php
require_once "../db/connect.php";
require_once "../db/classes/DbManagerInterface.php";
require_once "TableSummary.php";

class DbClass implements DbManagerInterface
{
    private $tableSummaries;

    public function __construct()
    {
        $this->tableSummaries = TableSummary::getTableSummaries();
    }

    /**
     * Reads one row of data from the database of the $table table and primary id(s) of that row.
     *
     * @param Entry $table
     * @param array $ids
     * Must use an array of ids even if there is only one id in the array
     * @return array
     * The full row data of the table with id(s)
     */
    public static function readById(Entry $table, array $ids)
    {
        $tableSummary = self::getTableSummary($table);

        // PART 1: CREATING SQL STATEMENT
        $dbPrimaryAttributes = $tableSummary->getDbPrimaryAttributes();
        $tableName           = $tableSummary->getDbTableName();

        $conditionals = array();
        foreach ($dbPrimaryAttributes as $dbPrimaryAttribute) {
            array_push($conditionals, $dbPrimaryAttribute . "=?");
        }
        $conditional = join(" AND ", $conditionals);

        $statement = newPDO()->prepare("SELECT * FROM {$tableName} WHERE {$conditional}");
        // PART 2: BIND PARAMETERS
        for ($index = 0; $index<count($dbPrimaryAttributes); $index++) {
            $values[$index] = $ids[$index];
            $statement->bindParam($index + 1, $values[$index]);
        }

        // PART 3: EXECUTE
        $statement->execute();
        return $statement->fetch();

        /*
         * TODO low priority, see source code
         * May still be used in replacement of the above two statements if multiple id's are provided.
         * To be implemented
         * Abstract the following fetch logic to its own function so it can be used by other functions
        $result = array();
        if($statement->execute())
        {
            while($row = $statement->fetch())
            {
                array_push($result, $row);
            }
            return $result;
        } else {
            false;
        }
        */
    }

    /**
     * Inserts a new entry into the database. Values in the class are the values to be used when inserting.
     *
     * @param $entry
     * The entry that is to be inserted into the database.
     * @return bool
     * returns true if the insertion was successful; otherwise returns false.
     */
    public static function insert(Entry $entry)
    {
        $tableSummary = self::getTableSummary($entry);

        // PART 1: CREATING SQL STATEMENT
        $tableName = $tableSummary->getDbTableName();
        $attributes = $tableSummary->getAttributes();
        $dbAttributes = $tableSummary->getDbAttributes();
        $columns = join(", ", $dbAttributes);

        // formatting values to have a number of parameters ("?") equal to the number of attributes for the table
        // e.g. if a table has five attributes then there will be five "?" like this: "?, ?, ?, ?, ?"
        $values = "?";
        for ($index=0; $index<count($dbAttributes) - 1; $index++)
        {
            $values .= ", ?";
        }

        $pdo = newPDO();
        $statement = $pdo->prepare("INSERT INTO {$tableName}({$columns}) VALUES ({$values})");

        // PART 2: BIND PARAMETERS
        for ($index=0; $index < count($attributes); $index++)
        {
            $value[$index] = self::getValueOfAttribute($entry, $attributes[$index]);
            $statement->bindParam($index+1, $value[$index]);
        }

        // PART 3: EXECUTE
        $isSuccessful = $statement->execute();

        // PART 4: SETTING THE PRIMARY ATTRIBUTE OF THE ENTRY
        if ($isSuccessful)
        {
            $primaryAttribute = ucfirst($tableSummary->getPrimaryAttributes()[0]);
            $primaryAttributeFunctionName = "set{$primaryAttribute}";
            $entry->$primaryAttributeFunctionName($pdo->lastInsertId());
        }

        return $isSuccessful;
    }

    /**
     * Update all attributes in the database to the current attribute values represented in the class. The entry must exist. in the database to update the entry.
     * Returns false if the primary key is not set; indicating that there is no entry in the database.
     *
     * @param $entry
     * The entry to be updated. The id attribute must be set in order to update the entry, otherwise the update will fail
     * @return bool
     * returns true if the update is successful; otherwise returns false.
     */
    public static function update(Entry $entry)
    {
        $tableSummary = self::getTableSummary($entry);

        $primaryAttributesAreNotEmpty = true;
        foreach ($tableSummary->getPrimaryAttributes() as $primaryAttribute)
        {
            if ($isset = empty(self::getValueOfAttribute($entry, $primaryAttribute))) // if the primary value is empty
            {
                $primaryAttributesAreNotEmpty = false;
            }
        }

        // checks if the primary attributes are not empty. If the primary values are empty, then that implies that the entry does not exist in the database
        if ($primaryAttributesAreNotEmpty) {
            // PART 1: CREATING SQL STATEMENT
            $dbAttributes        = $tableSummary->getDbAttributes();
            $dbPrimaryAttributes = $tableSummary->getDbPrimaryAttributes();

            $tableName = $tableSummary->getDbTableName();
            $values    = self::getJoinedColumnEqualsParameter($dbAttributes);

            $conditionals = array();
            foreach ($dbPrimaryAttributes as $dbPrimaryAttribute) {
                array_push($conditionals, $dbPrimaryAttribute . "=?");
            }
            $conditional = join(" AND ", $conditionals);


            //$conditionals = self::getJoinedColumnEqualsParameter($dbPrimaryAttributes);

            $statement = newPDO()->prepare("UPDATE {$tableName} SET {$values} WHERE {$conditional}");

            // PART 2: BIND PARAMETERS
            // Can't use the "+" operator because it does not append elements, rather it overwrites them.
            $parameters = $tableSummary->getAttributes();
            foreach ($tableSummary->getPrimaryAttributes() as $primaryAttribute) {
                array_push($parameters, $primaryAttribute);
            }

            $value = array();
            for ($index = 0; $index<count($parameters); $index++) {
                $value[$index] = self::getValueOfAttribute($entry, $parameters[$index]);
                $statement->bindParam($index+1, $value[$index]);
            }

            // PART 3: EXECUTE
            return $statement->execute();
        } else {
            return false;
        }

}

    public static function delete(Entry $entry) {
        // TODO: Test delete() method.
        $tableSummary = self::getTableSummary($entry);
        // PART 1: CREATING SQL STATEMENT
        $tableName   = $tableSummary->getDbTableName();
        $conditional = self::getJoinedColumnEqualsParameter($tableSummary->getDbPrimaryAttributes());

        $statement = newPdo()->prepare("DELETE FROM {$tableName} WHERE {$conditional}");

        // PART 2: BIND PARAMETERS
        $primaryAttributes = $tableSummary->getPrimaryAttributes();
        for ($index = 0; $index>count($primaryAttributes); $index++) {
            $values[$index] = self::getValueOfAttribute($entry, $primaryAttributes[$index]);
            $statement->bindParam($index + 1, $values[$index]);
        }

        // PART 3: EXECUTE
        return $statement->execute();

    }

    public static function save(Entry $entry)
    {
        $tableSummary = self::getTableSummary($entry);

        if (self::getValuesOfAttributes($entry, $tableSummary->getPrimaryAttributes())) // if the value of the primary key exists (is truthy)
        {
            self::update($entry);
        } elseif (false) { // TODO change "false" to fit the following condition: if the value of a secondary key matches a value of a database secondary key
            //e.g. secondary key for attendee is email and secondary key for Event is eventbrite id
            self::update($entry);
        } else {
            self::insert($entry);
        }
    }

    /**
     * Takes an $entry and defined attribute $attributeName and returns $entry->get<$attributeName>().
     * Example: given an Attendee entry and attribute name "email", this will return $attendee->getEmail()
     *
     * @param $entry
     * Must be an instance of a subclass of Entry.
     * The list of available subclasses of Entry are accessible in the TableSummary class
     * @param string $attributeName
     * the attribute variable name in the given subclass.
     * The list of available attribute names for each subclass are accessible in the TableSummary class
     * @return mixed
     */
    private static function getValueOfAttribute(Entry $entry, string $attributeName)
    {
        $getAttribute = "get".ucfirst($attributeName);
        return $entry->$getAttribute();
    }

    /**
     * Takes an $entry and an array of strings where each string is a class defined attribute $attributeName and returns an array of $entry->get<$attributeName>()
     *
     * @param $entry
     * The subclass instance of Entry.
     * The list of available subclasses of Entry are accessible in the TableSummary class
     * @param array $attributeNames
     * An array of attribute names in that entry.
     * The list of available attribute names for each subclass are accessible in the TableSummary class
     * @return array
     */
    private static function getValuesOfAttributes(Entry $entry, array $attributeNames)
    {
        $attributeValues = array();
        foreach ($attributeNames as $attrName)
        {
            array_push($attributeValues, self::getValueOfAttribute($entry, $attrName));
        }

        return $attributeValues;
    }

    private static function getTableSummary(Entry $entry) : TableSummary
    {
        $tableSummaries = TableSummary::getTableSummaries();
        return $tableSummaries[get_class($entry)];
    }

    /**
     * takes an array of strings representing database columns for one table and returns a string of repeated "<$dbColumn>=?" where each "<$dbColumn>=?" is joined together with commas to form one string.
     *
     * @param array $dbColumns
     * The list of available column names for each database table are accessible in the TableSummary class
     * @return string
     */
    private static function getJoinedColumnEqualsParameter(array $dbColumns) : string {
        $values = array();
        foreach ($dbColumns as $dbColumn) {
            $columnEqualsParameter = $dbColumn . "=? ";
            array_push($values, $columnEqualsParameter);
        }

        $values = join(", ", $values);

        return $values;
    }

    public static function getAllEventsAfterCurrentDate(){
        $statement = newPDO()->prepare("SELECT * FROM event WHERE Date >= DATE(NOW())"); //Fetch all events after current date
        $info = array();
        if($statement->execute()) {
            while($row = $statement->fetch()) {
                array_push($info, $row);
            }
        }
        return $info;
    }

    public static function getAllEvents(){
        $statement = newPDO()->prepare("SELECT * FROM event"); //Fetch all events
        $info = array();
        if($statement->execute()) {
            while($row = $statement->fetch()) {
                array_push($info, $row);
            }
        }
        return $info;
    }

    public static function getAllAttendees(){
        $statement = newPDO()->prepare("SELECT * FROM attendee");
        $info = array();
        if($statement->execute()){
            while($row = $statement->fetch()){
                array_push($info, $row);
            }
        }
        return $info;
    }

    public static function getAttendeesForEvent($eventID){
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT Id, Fname, Lname, Email, Phone FROM attendee, attendance, event WHERE event.Eventid = attendance.Eventid AND attendee.Id = attendance.Attendeeid AND event.Eventid = ?");
        $statement->bindParam(1, $eventID);
        $info = array();
        if($statement->execute()) {
            while($row = $statement->fetch()) {
                array_push($info, $row);
            }
        }
        return $info;
    }

    public static function checkAttendanceByID($attendeeID, $eventID){
        // TODO delete This can already be done by creating an Attendee() and checking getIsAttended()
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT COUNT(*) AS num FROM attendance WHERE Attendeeid = ? AND Eventid = ? AND Attended = TRUE");
        $statement->bindParam(1, $attendeeID);
        $statement->bindParam(2, $eventID);
        if($statement->execute()){
            $result = $statement->fetch();
            return $result['num']>0;
        }
        else{
            return FALSE;
        }
    }

    public static function setAttendedTrue($attendeeID, $eventID){
        $pdo = newPDO();
        $statement = $pdo->prepare("UPDATE attendance SET Attended = TRUE WHERE Eventid = ? AND Attendeeid = ?");
        $statement->bindParam(1, $eventID);
        $statement->bindParam(2, $attendeeID);
        return $statement->execute();
    }

    public static function doesAttendeeExist($fname, $lname, $email) {
        // TODO delete doesAttendeeExist()?
        // The same functionality can be implemented by getAttendeeByName()
        // They have the same the same signature input. Null output from getAttendeeByName() can be interpreted as false and the array return can be interpreted as true.
        $pdo       = newPDO();
        $statement = $pdo->prepare("SELECT COUNT(*) AS num FROM attendee WHERE Fname = ? AND Lname = ? AND Email = ?");
        $statement->bindParam(1, $fname);
        $statement->bindParam(2, $lname);
        $statement->bindParam(3, $email);
        if ($statement->execute()) {
            $result = $statement->fetch();
            return $result['num']>0;
        } else {
            return FALSE;
        }
    }

    public static function getAttendeeByName($fname, $lname, $email){
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT * FROM attendee WHERE Fname = ? AND Lname = ? AND Email = ?");
        $statement->bindParam(1, $fname);
        $statement->bindParam(2, $lname);
        $statement->bindParam(3, $email);
        if($statement->execute()) {
            return $statement->fetch();
        }
        else{
            return NULL;
        }
    }

    public static function getAttendeeByID($id){
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT * FROM attendee WHERE Id = ?");
        $statement->bindParam(1, $id);
        if($statement->execute()) {
            return $statement->fetch();
        }
        else{
            return NULL;
        }
}

    public static function getAttendanceByEventId($eventid){
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT sum(Walkin) AS walkin, sum(Registered) AS registered, sum(Attended) AS attended FROM attendance WHERE Eventid = ?");
        $statement->bindParam(1, $eventid);
        if($statement->execute()) {
            return $statement->fetch();
        }
        else{
            return NULL;
        }
    }

    public static function isAttendeeRegistered($attendeeID, $eventID) : bool {
        $pdo       = newPDO();
        $statement = $pdo->prepare("SELECT COUNT(*) AS num FROM attendance WHERE Attendeeid = ? AND Eventid = ? AND Registered = TRUE");
        $statement->bindParam(1, $attendeeID);
        $statement->bindParam(2, $eventID);
        if ($statement->execute()) {
            $result = $statement->fetch();
            return $result['num']>0;
        } else {
            return false;
        }
    }

    public static function addRegistration($attendeeID, $eventID, $walkIn) : bool {
        $pdo       = newPDO();
        $statement = $pdo->prepare("INSERT INTO attendance(Attendeeid, Eventid, Registered, Walkin, Attended) VALUES (?, ?, TRUE, ?, FALSE)");
        $statement->bindParam(1, $attendeeID);
        $statement->bindParam(2, $eventID);
        $statement->bindParam(3, $walkIn);
        return $statement->execute();
    }

    public static function checkPasswordMatch($username, $password){
        $pdo = newPDO();
        $hashedPassword = sha1($password);
        $statement = $pdo->prepare("SELECT COUNT(Username) AS num FROM user WHERE Username = ? AND Password = ?");
        $statement->bindParam(1, $username);
        $statement->bindParam(2, $hashedPassword);
        if($statement->execute())
        {
            $info = $statement->fetch();
            return $info['num'] == 1;
        }
        else{
            return FALSE;
        }
    }

    public static function getAttendance($eventID, $attendeeID){
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT * FROM attendance WHERE Eventid = ? AND Attendeeid = ?");
        $statement->bindParam(1, $eventID);
        $statement->bindParam(2, $attendeeID);
        if($statement->execute()){
            return $statement->fetch();
        }
        else{
            return NULL;
        }
    }

    public static function getEventsByName($query){
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT * FROM event WHERE Name LIKE CONCAT('%',?,'%')");
        $statement->bindParam(1, $query);
        $info = array();
        if($statement->execute()) {
            while($row = $statement->fetch()) {
                array_push($info, $row);
            }
        }
        return $info;
    }
}

