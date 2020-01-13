<?php
	session_start();
?>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel = "stylesheet" type = "text/css" href = "/css/register.css">
	</head>
	<body>
		<div id = "main">
			<h1>Register</h1>
			<form method = "post">
				<span id = "field">First Name <input class = "input" type = "text" name = "fname" required value="<?php echo isset($_POST["fname"]) ? $_POST["fname"] : ''?>"></span>
				<br><br>
				<span id = "field">Last Name <input class = "input" type = "text" name = "lname" required value="<?php echo isset($_POST["lname"]) ? $_POST["lname"] : ''?>"></span>
				<br><br>
				<span id = "field">Email <input class = "input" type = "email" name = "email" required value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''?>"></span>
				<br><br>
				<input class = "submit" type = "submit" value = "Submit">
			</form>
			<form method = "post" action = "/ui/checkin.php">
				<button class = "submit">Back</button>
			</form>
		</div>
	</body>
</html>

<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	include_once $root . "/php/checkRegistration.php";
	include_once $root . "/db/addAttendee.php";
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