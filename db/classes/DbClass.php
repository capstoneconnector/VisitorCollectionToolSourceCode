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
     * Pulls an entry from a table using the id(s) of the entry and returns an array
     *
     * @param int $ids
     * The row entry of the corresponding id(s)
     * @return array
     * The full row data of the corresponding id(s) pulled from the db of the class with corresponding name
     */

    /**
     * What is it?
     * examples: readById(new Attendee, [10000])
     * @param Entry $table
     * @param array $ids
     * @return array
     * The full row data of the corresponding id pulled from the db of the class with corresponding name
     */
    public static function readById(Entry $table, array $ids)
    {
        $tableSummary = self::getTableSummary($table);
        $dbPrimaryAttributes = $tableSummary->getDbPrimaryAttributes();
        $tableName = $tableSummary->getTableName();
        $conditional = self::getColumnEqualsParameter($dbPrimaryAttributes);


        $statement = newPDO()->prepare("SELECT * FROM {$tableName} WHERE {$conditional}");

        // binding parameters
        for ($index=0; $index < count($dbPrimaryAttributes); $index++)
        {
            $statement->bindParam($index+1, $ids[$index]);
        }

        $statement->execute();
        return $statement->fetch();

        /*
         * TODO low priority, see source code
         * May still be used in replacement of the above two statements if multiple id's are provided.
         * To be implemented
         * Abstract the following fetch logic to its own function
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
     * Inserts a new entry into the table corresponding to the name of the class using the specified attributes in that
     * class
     *
     * @param $entry
     * refers to the entry that needs to be inserted into the database
     * @return bool
     * returns true if the insertion was successful; otherwise returns false.
     */
    public static function insert(Entry $entry)
    {
        $tableSummary = self::getTableSummary($entry);
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

        $statement = newPDO()->prepare("INSERT INTO {$tableName}({$columns}) VALUES ({$values})");

        // binding parameters
        for ($index=0; $index < count($attributes); $index++)
        {
            $value[$index] = self::getValueOfAttribute($entry, $attributes[$index]);
            $statement->bindParam($index+1, $value[$index]);
        }

        return $statement->execute(); // TODO returns the id of the insted entry. see https://www.w3schools.com/php/php_mysql_insert_lastid.asp
    }

    /**
     * Resets all attributes in the database to the current attribute values represented in the class. The entry must exist
     * in the database to update the entry.
     * Throws error if the primary key is not set; indicating that there is no entry in the database.
     *
     * @param $entry
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
        if ($primaryAttributesAreNotEmpty)
        {
            $dbAttributes = $tableSummary->getDbAttributes();
            $dbPrimaryAttributes = $tableSummary->getDbPrimaryAttributes();

            $tableName = $tableSummary->getDbTableName();
            $values = self::getColumnEqualsParameter($dbAttributes);
            $conditionals = self::getColumnEqualsParameter($dbPrimaryAttributes);

            $statement = newPDO()->prepare("UPDATE {$tableName} SET {$values} WHERE {$conditionals}");

            // binding parameters
            // Can't use the "+" operator because it does not append elements, rather it overwrites them.
            // ex $dbAttributes = array([0]=>"Id", ...) and $dbPrimaryAttributes = array([0]=>"Id"). I want both instances to exist in $parameters with each element of $dbPrimaryAttributes being appended at the end of $dbAttributes
            $parameters = $tableSummary->getAttributes();
            foreach ($tableSummary->getPrimaryAttributes() as $primaryAttribute)
            {
                array_push($parameters, $primaryAttribute);
            }
            $value = array();
            for ($index=0; $index < count($parameters); $index++)
            {
                $value[$index] = self::getValueOfAttribute($entry, $parameters[$index]);
                $statement->bindParam($index+1, $value[$index]);
            }

            return $statement->execute();
        } else {
            return false;
        }

}

    public static function delete()
    {
        // TODO: Implement delete() method.
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
            // TODO set the subclass id(s) to the newly created entry id(s)
            //see https://www.w3schools.com/php/php_mysql_insert_lastid.asp
        }
    }

    /**
     * Takes a class defined attribute $attributeName and returns get<$attributeName>() for that attribute in that class.
     * Example: an attribute named "email" will return getEmail().
     *
     * @param string $attributeName
     * @return mixed
     */
    private static function getValueOfAttribute(Entry $entry, string $attributeName)
    {
        $getAttribute = "get".ucfirst($attributeName);
        return $entry->$getAttribute();
    }

    /**
     * Takes an array of strings where each string is a class defined attribute <name> and returns an array of the
     * result of the get<name>() function declared in that class
     * @param array $attributeNames
     * @return array
     */
    private static function getValuesOfAttributes(Entry $entry, array $attributeNames)
    {
        $tableSummaries = TableSummary::getTableSummaries();
        $tableType = $tableSummaries[get_class($entry)];

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

    private static function getColumnEqualsValuePair(Entry $entry, array $dbColumns, array $values)
    {
        if (count($dbColumns) != count($values))
        {
            return new Exception("columns and values arrays must be the same length");
        }

        $columnValuePairs = array();
        for ($index=0; $index<count($dbColumns); $index++)
        {
            $columnValuePair = $dbColumns[$index] . "=" . self::getValueOfAttribute($entry, $values[$index]) . " ";
            array_push($columnValuePairs, $columnValuePair);
        }

        return $columnValuePairs;
    }

    private static function getColumnEqualsParameter(array $dbColumns)
    {
        $values = array();
        foreach ($dbColumns as $dbColumn)
        {
            $columnEqualsParameter = $dbColumn . "=? ";
            array_push($values, $columnEqualsParameter);
        }

        $values = join(", ", $values);

        return $values;
    }

    private static function getColumnEqualsValue(array $dbColumns, array $values)
    {
        if (count($dbColumns) != count($values))
        {
            return new Exception("columns and values arrays must be the same length");
        }

        $columnsEqualsValues = array();
        for ($index=0; $index<count($dbColumns);$index++)
        {
            $columnEqualsValue = $dbColumns[$index] . "=" . $values[$index] ." ";
            array_push($columnsEqualsValues, $columnEqualsValue);
        }

        return $columnsEqualsValues;

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

    public static function getEventByID($id) {
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT * FROM event WHERE Eventid=?"); //Fetch specific event by id
        $statement->bindParam(1, $id);
        $statement->execute();
        return $info = $statement->fetch();
    }

    public static function checkAttendanceByID($attendeeID, $eventID){
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT COUNT(*) AS num FROM attendance WHERE Attendeeid = ? AND Eventid = ? AND Attended = TRUE");
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
        else{
            return FALSE;
        }
    }

    public static function setAttendedTrue($attendeeID, $eventID){
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

    public static function doesAttendeeExist($fname, $lname, $email){
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT COUNT(*) AS num FROM attendee WHERE Fname = ? AND Lname = ? AND Email = ?");
        $statement->bindParam(1, $fname);
        $statement->bindParam(2, $lname);
        $statement->bindParam(3, $email);
        if($statement->execute()){
            $result = $statement->fetch();
            if($result['num'] > 0){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        else{
            return FALSE;
        }
    }

    public static function addAttendee($fname, $lname, $email, $phone){
        $pdo = newPDO();
        $statement = $pdo->prepare("INSERT INTO attendee(Fname, Lname, Phone, Email) VALUES(?,?,?,?)");
        $statement->bindParam(1, $fname);
        $statement->bindParam(2, $lname);
        $statement->bindParam(3, $phone);
        $statement->bindParam(4, $email);
        if($statement->execute()){
            return $pdo->lastInsertId();
        }
        else{
            return NULL;
        }
    }

    public static function addEvent($name, $description, $date){
        $pdo = newPDO();
        $statement = $pdo->prepare("INSERT INTO event(Name, Description, Date) VALUES(?,?,?)");
        $statement->bindParam(1, $name);
        $statement->bindParam(2, $description);
        $statement->bindParam(3, $date);
        if($statement->execute()){
            return TRUE;
        }
        else{
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

    public static function isAttendeeRegistered($attendeeID, $eventID){
        $pdo = newPDO();
        $statement = $pdo->prepare("SELECT COUNT(*) AS num FROM attendance WHERE Attendeeid = ? AND Eventid = ? AND Registered = TRUE");
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
        else{
            return FALSE;
        }
    }

    public static function addWalkinRegistration($attendeeID, $eventID){
        $pdo = newPDO();
        $statement = $pdo->prepare("INSERT INTO attendance(Attendeeid, Eventid, Registered, Walkin, Attended) VALUES (?, ?, TRUE, TRUE, FALSE)");
        $statement->bindParam(1, $attendeeID);
        $statement->bindParam(2, $eventID);
        if($statement->execute()){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public static function addRegistration($attendeeID, $eventID, $walkIn){
        $pdo = newPDO();
        $statement = $pdo->prepare("INSERT INTO attendance(Attendeeid, Eventid, Registered, Walkin, Attended) VALUES (?, ?, TRUE, ?, FALSE)");
        $statement->bindParam(1, $attendeeID);
        $statement->bindParam(2, $eventID);
        $statement->bindParam(3, $walkIn);
        if($statement->execute()){
            return TRUE;
        }
        else{
            return FALSE;
        }
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
            if($info['num'] == 1)
            {
                return TRUE;
            }
            else {
                return FALSE;
            }
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
}

