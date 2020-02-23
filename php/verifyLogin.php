<?php
require_once "../db/classes/DbClass.php";

function verifyLogin($username, $password){
    if(DbClass::checkPasswordMatch($username, $password)){
        return TRUE;
    }
    else{
        return FALSE;
    }
}
