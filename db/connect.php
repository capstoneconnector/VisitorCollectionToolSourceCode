<?php
function newPDO()
{
    require_once "C:/xampp/htdocs/VisitorCollectionToolSourceCode/php/parseConfig.php";

    //require_once "../php/parseConfig.php";

    $config = parseConfig();

    $hostname = $config["hostname"];
    $username = $config["username"];
    $db = $config["db"];
    $password = $config["password"];
    $charset = $config["charset"];

    $dsn = "mysql:host=$hostname;dbname=$db;charset=$charset";

    return new PDO($dsn, $username, $password);
}