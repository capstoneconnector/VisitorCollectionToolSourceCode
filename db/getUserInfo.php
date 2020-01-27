<?php
	function verifyLogin($username, $password){
		require_once "../php/parseConfig.php";
		$hashedpass = sha1($password);
		$cfg = parseConfig();
		$pdo = new PDO('mysql:host=' . $cfg['hostname'] . ';dbname=' . $cfg['db'], $cfg['username'], $cfg['password']);
		$stmt = $pdo->prepare("SELECT COUNT(Username) AS num FROM user WHERE Username = ? AND Password = ?");
		$stmt->bindParam(1, $username);
		$stmt->bindParam(2, $hashedpass);
		if($stmt->execute()){
	        $info = $stmt->fetch();
	        if($info['num'] == 1){
	        	return TRUE;
	        }
	        else{
	        	return FALSE;
	        }
	    }
	}
?>