<?php
    function findName($name, $event){
        $root = $_SERVER['DOCUMENT_ROOT'];
        include_once $root . "/db/connect.php";
        $info = array();
        $names = explode(" ", $name);
        $fnameparam = $names[0];
        $lnameparam = $names[1];
        $stmt = $pdo->prepare("SELECT Id, Fname, Lname, Email FROM attendee WHERE Eventid = ? AND Attended = 0 AND Fname LIKE CONCAT('%',?,'%') AND Lname LIKE CONCAT('%',?,'%')");
        $stmt->bindParam(1, $event);
        $stmt->bindParam(2, $fnameparam);
        $stmt->bindParam(3, $lnameparam);
        if($stmt->execute()){
            while($row = $stmt->fetch()){
                array_push($info, $row);
            }
        }
        return $info;
    }
?>