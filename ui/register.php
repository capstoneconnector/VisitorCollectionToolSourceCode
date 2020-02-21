<?php
	session_start();
	if(empty($_SESSION['logged'])){
		header ('location: login.php');
	}
?>

<html lang="php">
	<head>
        <title>Registration</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel = "stylesheet" type = "text/css" href = "/css/register.css">

		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<!-- Popper.JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<!-- Bootstrap JS -->
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	</head>
	<body>
    <div id="main">
					<div class="col-10">
						<table width = "100%" style = "background:#05163D; color: honeydew" align="right">
                            <tr>
                                <td></td>
                                <td>
                                    <div class="container mt-1" id="menu">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary " data-toggle="dropdown">
                                                <span class=""><i class="fas fa-bars fa-1x"></i></span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="login.php">Set Up</a>
                                                <a class="dropdown-item" href="checkin.php">Check In</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                <td width = "115">
                                <td>
                                    <h2>Registration</h2>
                                </td>
                                <td width = "45">&nbsp;</td>
                            </tr>
                        </table>
			<form method = "post">
				<label id = "field">First Name <input class = "input" type = "text" name = "fname" required value="<?php echo isset($_POST["fname"]) ? $_POST["fname"] : ''?>"></label>
				<br><br>
				<label id = "field">Last Name <input class = "input" type = "text" name = "lname" required value="<?php echo isset($_POST["lname"]) ? $_POST["lname"] : ''?>"></label>
				<br><br>
				<label id = "field">Email <input class = "input" type = "email" name = "email" required value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''?>"></label>
				<br><br>
                <label id = "field">Phone Number <input class = "input" type = "text" name = "phone" required value="<?php echo isset($_POST["phone"]) ? $_POST["phone"] : ''?>"></label>
                <br><br>
				<input class = "submit" type = "submit" value = "Submit">
			</form>
			<form method = "post" action = "checkin.php">
				<button class = "submit">Back</button>
			</form>
		</div>
    </body>
</html>

<?php
	require_once "../php/checkRegistration.php";
    require_once "../php/getEventInfo.php";
	require_once "../db/dbInterface.php";
    require_once "../php/registerAttendee.php";
    require_once "../php/checkAttendeeExists.php";
    require_once "../php/getAttendeeInfo.php";
    require_once "../php/createAttendee.php";

	if(!empty($_POST)){
		if(!empty($_POST["fname"]) and !empty($_POST["lname"]) and !empty($_POST["email"])){
			$fname = $_POST["fname"];
			$lname = $_POST["lname"];
			$email = $_POST["email"];
			$phone = $_POST["phone"];
            $event = getEvent($_SESSION["eventId"]);
			if(!checkAttendeeExists($fname, $lname, $email)){
			    $attendee = createAttendee($fname, $lname, $email, $phone);
            }
			else{
			    $attendee = getAttendeeFromAttributes($fname, $lname, $email);
			    var_dump($attendee);
            }
			if(checkRegistration($attendee, $event) == FALSE){
				registerAttendee($attendee, $event);
				echo "<script type='text/javascript'>";
				echo "alert('Registration Successful!');";
				echo "window.location = ('checkin.php');";
				echo "</script>";
			}

			else{
				echo '<script type="text/javascript\">';
				echo 'alert("User already exists, try again!")';
				echo '</script>';
			}

			
		}
		
		else{
			echo '<script type="text/javascript\">';
			echo 'alert("Some fields are empty, try again!")';
			echo '</script>';
		}
	}
?>