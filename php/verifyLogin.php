<?php
require_once "../db/classes/DbClass.php";

function verifyLogin($username, $password){
    return DbClass::checkPasswordMatch($username, $password);
}
