<?php
	session_start();
	if(empty($_SESSION['logged'])){
		header ('location: login.php');
	}
?>
<html lang="php">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="/js/checkin.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/checkin.css">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<!-- Popper.JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<!-- Bootstrap JS -->
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<title>Check In</title>
	</head>
	<body>
		<div class="container">
			<div class="row">
			</div>
			<div id="main">
				<div class="col-12">
					<table width = "100%" style = "background:#05163D; color: honeydew" align="right">
						<tr>
							<td>&nbsp;</td>
							<td>
								<div class="container mt-1" id="menu">
									<div class="dropdown">
										<button type="button" class="btn btn-primary " data-toggle="dropdown">
											<span class=""><i class="fas fa-bars fa-1x"></i></span>
										</button>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="login.php">Set Up</a>
											<a class="dropdown-item" href="register.php">Registration</a>
										</div>
									</div>
								</div>
				</div>
							<td width = "95">&nbsp;</td>
							<td>
								<h2>Check In</h2>
							</td>
							<td width = "45">&nbsp;</td>
                         </tr>
                    </table>
					<?php
                        require_once "../php/getEventInfo.php";
						$event = getEvent($_SESSION["eventId"]); //Use session var for event name
						echo "<h2>" . $event->getName() . "</h2>";
					?>
					<br>
					<form method="post">
					<span id="prompt">Enter Your Name</span>
					<br><br>
                        <label>
                            <input class="input" type="text" name="name" required>
                        </label>
                        <br><br>
					<input class="submit" type="submit" value="Check In">
					<br><br>
					</form>
					<br><br><br>
					<div class="table">
					<?php
                        require_once "../php/getEventInfo.php";
						require_once "../php/findName.php";
						$event = $_SESSION['eventId'];
						if(!empty($_POST)){
							if(!empty($_POST["name"])){
								$name = $_POST["name"];
								$event = getEvent($_SESSION["eventId"]);
								$names = findName($name, $event); //Fetch names that match name entered by user
								if(!empty($names)){ //Only creates table if there is content to write to it
									echo '<table border = 3>';
									echo '<th>First Name</th><th>Last Name</th><th>Email</th><th></th>';
									for ($i = 0; $i < sizeof($names); $i++){
										echo '<tr>';
										echo '<td>' . $names[$i]->getFirstName() . '</td>';
										echo '<td>' . $names[$i]->getLastName() . '</td>';
										echo '<td>' . $names[$i]->getEmail() . '</td>';  //Table creation markup
									echo "<td><button id = '". $i . "' onclick= verifyUser('".$names[$i]->getId()."','".$names[$i]->getEmail()."','". $event->getId()."')>This is me</button>"; //Tie user email and id to the UI button to send to AJAX function
									echo '</tr>';
									}
								echo '</table>';
								}
								else{
									echo '<script language="javascript">';
									echo 'alert("Name not found, try again or ask for help!")';
									echo '</script>';
								}
							}
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>