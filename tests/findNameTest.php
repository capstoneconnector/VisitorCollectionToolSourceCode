<?php
	include_once "../php/findName.php"; 

	class FindNameTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
		public function setUp(){
			$this->eventid = 999;
		}
		public function tearDown(){
		}

		function testFindNameOneResult(){
			$this->assertSame(findName("John Smith", $this->eventid)[0]['Email'], "jsmith@gmail.com");
	
		}

		function testFindNameMoreThanOneResult(){
			$this->assertSame(findName("Bob Jones", $this->eventid)[1]['Email'], "bjones2@gmail.com");
		}

		function testFindNameNoResultsWhenAlreadyRegistered(){
			$this->assertEmpty(findName("Mary Jane", $this->eventid));
		}

		function testFindNameNoResults(){
			$this->assertEmpty(findName("John Doe", $this->eventid));
		}
	}
?>