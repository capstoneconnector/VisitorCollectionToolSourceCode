<?php
	include_once "findName.php"; 

	class FindNameTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
		public function setUp(){
			$this->info = [["Bob","Jones","bjones@gmail.com",0],
							["Mary","Jane","mjane@gmail.com",1],
							["Bob", "Jones", "bjones2910@yahoo.com",0], 
							["John", "Smith", "jsmith@gmail.com",0]];
		}
		public function tearDown(){
		}

		function testFindNameOneResult(){
			$this->assertSame(findName("John Smith", $this->info), array($this->info[3]));
	
		}

		function testFindNameMoreThanOneResult(){
			$this->assertSame(findName("Bob Jones", $this->info), array($this->info[0], $this->info[2]));
		}

		function testFindNameNoResultsWhenAlreadyRegistered(){
			$this->assertEmpty(findName("Mary Jane", $this->info));
		}

		function testFindNameNoResults(){
			$this->assertEmpty(findName("John Doe", $this->info));
		}
	}
?>