<?php
    function findName($name, $event){
        $root = $_SERVER['DOCUMENT_ROOT'];
        include_once $root . "/db/getAttendeeInfo.php";
        $names = explode(" ", $name);
        $fname = $names[0];
        $lname = $names[1];
        return getAttendeeInfoFromName($event, $fname, $lname);
    }
?>