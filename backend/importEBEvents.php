<?php
require_once "../backend/parseConfig.php";
require_once "../backend/ebinterface.php";
$config = parseConfig();
$token  = $config['PRIVATE_TOKEN'];
if (!empty($token)) {
    importEbEvents($token);
}