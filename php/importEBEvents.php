<?php
require_once "../php/parseConfig.php";
require_once "../php/ebinterface.php";
$config = parseConfig();
$token = $config['PRIVATE_TOKEN'];
if(!empty($token)){
    importEbEvents($token);
}