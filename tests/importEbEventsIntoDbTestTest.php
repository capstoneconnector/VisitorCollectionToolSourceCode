<?php
include_once "../businessLogic/ebinterface.php";

class importEbEventIntoDbTest extends PHPUnit_Framework_TestCase { //Run this file with phpunit command from command line

    private $pdo;

    function setup() {
        $this->pdo = newPDO();
    }

    function teardown()
    {
        $statement = $this->pdo->prepare("DELETE FROM attendance where email='facebook.ishepard@xoxy.net' OR email='kharmon3@bsu.edu'");
        $statement->execute();

        $statement = $this->pdo->prepare("DELETE FROM event WHERE Ebid=86470394277");
        $statement->execute();

    }

    function testRunImportEvents()
    {
		$oAuthToken = "COKR3D7YQAPZM2GWLOTL";
		importEbEvents($oAuthToken);

	}
}