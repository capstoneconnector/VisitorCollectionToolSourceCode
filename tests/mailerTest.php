<?php
include_once "../php/mailer.php";

class mailerTest extends PHPUnit_Framework_TestCase {

    function test_mail_true() {
        $mailed = mailer();
        var_dump($mailed);
        $this->assertTrue($mailed);
    }
}