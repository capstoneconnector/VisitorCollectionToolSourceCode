<?php
	include_once "../db/dbInterface.php";

	class AddEventTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
		public function setUp(){
		}
		public function tearDown(){
			$pdo = new PDO('mysql:host=localhost;dbname=icdb', "root", "");
			$stmt = $pdo->prepare("DELETE FROM event WHERE Name = 'Test Event' AND Date = '3000-01-01'");
			$stmt->execute();
		}

		function testAddEventSuccess(){
			$this->assertTrue(addEvent("Test Event", "3000-01-01"));
		}
	}