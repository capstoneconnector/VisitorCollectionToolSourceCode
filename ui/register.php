<?php
	session_start();
?>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel = "stylesheet" type = "text/css" href = "/css/register.css">

		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<div class="container">
			<div class="row">
				<div class="col-2">
				<title>Registration</title>
	</head>
	<body>
	</div>
		</div>
		<div id="main">
					<div class="col-10">
						<table width = "100%" style = "background:#05163D; color: honeydew" align="right">
							<tr>
								<td>&nbsp;</td>
								<td>
									<div class="container mt-1" id="menu">
									<button type="button" class="btn btn-success" data-toggle="collapse" data-target="#content">  </button>
										<div id="content" class="collapse">
											<li><a href='setup.php'><span>setup</span></a></li>
											<li class='last'><a href='checkin.php'><span>Check In</span></a></li>
										</div>
									</div>
								</td>
								<td>
									<h2>Registration</h2>
								</td>
								<td width = "45">&nbsp;</td>
							</tr>
						</table>
			<form method = "post">
				<span id = "field">First Name <input class = "input" type = "text" name = "fname" required value="<?php echo isset($_POST["fname"]) ? $_POST["fname"] : ''?>"></span>
				<br><br>
				<span id = "field">Last Name <input class = "input" type = "text" name = "lname" required value="<?php echo isset($_POST["lname"]) ? $_POST["lname"] : ''?>"></span>
				<br><br>
				<span id = "field">Email <input class = "input" type = "email" name = "email" required value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''?>"></span>
				<br><br>
				<input class = "submit" type = "submit" value = "Submit">
			</form>
			<form method = "post" action = "checkin.php">
				<button class = "submit">Back</button>
			</form>
		</div>
		</div>
	</body>
</html>

<?php
	require_once "../php/checkRegistration.php";
	require_once "../db/dbInterface.php";
	if(!empty($_POST)){
		if(!empty($_POST["fname"]) and !empty($_POST["lname"]) and !empty($_POST["email"])){
			$fname = $_POST["fname"];
			$lname = $_POST["lname"];
			$email = $_POST["email"];
			$event = $_SESSION['eventId'];
			
			if(checkRegistration($fname, $lname, $email, $event) == FALSE){ 
				registerUser($fname, $lname, $email, $event);
				echo "<script type='text/javascript'>";
				echo "alert('Registration and Check In Successful!');";
				echo "window.location = ('checkin.php');";
				echo "</script>";
			}

			else{
				echo '<script language="javascript">';
				echo 'alert("User already exists, try again!")';
				echo '</script>';
			}

			
		}
		
		else{
			echo '<script language="javascript">';
			echo 'alert("Some fields are empty, try again!")';
			echo '</script>';
		}
	}
?>