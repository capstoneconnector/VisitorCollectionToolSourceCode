<?php
	session_start();
	$_SESSION['logged'] = NULL;
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script> 
		<link rel = "stylesheet" type = "text/css" href = "/css/login.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<title>Login</title>
	</head>
	<body>
		<div id = "main">
			<span id = "header">Login</span>
			<form method = "post">
				<div class = "field">Username</div>
				<input type = "text" name = "username" required>
				<br><br>
				<div class = "field">Password</div>
				<input type = "password" name = "password" required>
				<br><br>
				<input type = "submit" value = "Login">
			</form>
		</div>
	</body>
</html>

<?php
	require_once "../db/getUserInfo.php";
	if(!empty($_POST)){
		$username = $_POST['username'];
		$password = $_POST['password'];
		if(verifyLogin($username, $password)){
			$_SESSION['logged'] = TRUE;
			echo "<script type='text/javascript'>";
			echo "window.location = ('setup.php');";
			echo "</script>";
		}
		else{
			echo '<script language="javascript">';
			echo 'alert("Login failed, try again!")';
			echo '</script>';
		}
	}
	