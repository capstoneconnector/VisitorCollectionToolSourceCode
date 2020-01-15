<?php
	$root = $_SERVER["DOCUMENT_ROOT"];
	include_once $root . "/php/checkRegistration.php";
	include_once $root . "/db/parseDBConfig.php";

	class CheckRegistrationTest extends PHPUnit_Framework_TestCase{ //Run this file with phpunit command from command line
		public function setUp(){
			$config = parseDBConfig();
			$hostname = $config['hostname'];
			$db = $config['db'];
			$username = $config['username'];
			$password = $config['password'];
			$pdo = new PDO('mysql:host=$hostname;dbname=$db', $username, $password);
			$stmt = $pdo->prepare("SELECT Eventid FROM event WHERE Name = 'Test Event for Testing Purposes'");
			if($stmt->execute()){
	        	$info = $stmt->fetch();
	    	}	
	    	$this->eventid = $info['Eventid'];
		}
		public function tearDown(){
		}

		function testCheckRegistrationFalse(){
			$this->assertFalse(checkRegistration($this->info, "jsmith22@gmail.com"));
	
		}

		function testCheckRegistrationTrue(){
			$this->assertTrue(checkRegistration($this->info, "mjane@gmail.com"));
		}
	}
?>