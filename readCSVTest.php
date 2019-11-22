<?php
	include_once "readCSV.php";

	class ReadCSVTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
		public function setUp(){
			$this->file = fopen("tests.csv", "r+");
		}
		public function tearDown(){
			fclose($this->file);
		}

		function testReadCSVEmail(){
			$this->assertSame("bjones@gmail.com", readCSV($this->file)[0][2]);
	
		}

		function testReadCSVFirstName(){
			$this->assertSame("Bob", readCSV($this->file)[0][0]);
		}

		function testReadCSVLastName(){
			$this->assertSame("Jones", readCSV($this->file)[0][1]);
		}
	}
?>
