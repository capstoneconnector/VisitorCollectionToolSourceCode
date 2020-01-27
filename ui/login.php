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
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<title>Login</title>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-2">
					<img src="/img/Innovation_Connector_Logo.png" width="150px"></img>
					
						<div id ="menu">
							<ul class="nav nav-pills nav-stacked">
								<li><a href='setup.php'><span>Set Up</span></a></li>
								<li><a href='manager.php'><span>Event</span></a></li>
							</ul>
						</div>
				</div>
				<div id = "main" class="col-10">
					<table width = "100%" style = "background:#05163D; color: honeydew" align="right">
						<tr>
							<td width = "20">&nbsp;</td>
							<td>
								<h2>Login</h2>
							</td>
							<td>&nbsp;</td>
							<td width = "10">&nbsp;</td>
						</tr>
						<tr>
							<td colspan "2"></td>
						</tr>
					</table>
					<form method = "post">
						</br></br></br>
						<div class = "field">Username</div>
						<input type = "text" name = "username" required>
						<br><br>
						<div class = "field">Password</div>
						<input type = "password" name = "password" required>
						<br><br>
						<input type = "submit" value = "Login">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>

<?php
	require_once "../db/dbInterface.php";
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
	