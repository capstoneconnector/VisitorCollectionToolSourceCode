<?php
	$root = $_SERVER["DOCUMENT_ROOT"];
	include_once $root . "/db/getEventInfo.php";
	session_start();
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="/js/checkin.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/checkin.css">
		<title>Check in</title>
	</head>
	<body>
		<div id="main">
			<h1>Check In</h1>
			<?php
				$event = getEventById($_SESSION["eventId"]); //Use session var for event name
				echo "<h2>" . $event["Name"] . "</h2>";
			?>
			<br>
			<form method="post">
				<span id="prompt">Enter your name</span>
				<br><br>
				<input class="input" type="text" name="name" required>
				<br><br>
				<input class="submit" type="submit" value="Search">
				<br><br>
			</form>
			<button class="submit" onclick="window.location = 'register.php'">Registration Page</button>
			<br><br><br>
			<button class="submit" onclick="window.location = 'setup.php'"><img src="../img/home_icon.png" alt="home icon" height="32"></button>
		</div>
		<br><br><br>
		<div class="table">
			<?php
				$root = $_SERVER['DOCUMENT_ROOT'];
				include_once $root . "/php/findName.php";
				$event = 1;
				if(!empty($_POST)){
					if(!empty($_POST["name"])){
						$name = $_POST["name"];
						$names = findName($name, $event); //Fetch names that match name entered by user
						if(sizeof($names) !== 0){ //Only creates table if there is content to write to it
							echo '<table border = 3>';
							echo '<th>First Name</th><th>Last Name</th><th>Email</th>';
							for ($i = 0; $i < sizeof($names); $i++){
								echo '<tr>';
								echo '<td>' . $names[$i]['Fname'] . '</td>';
								echo '<td>' . $names[$i]['Lname'] . '</td>'; 
								echo '<td>' . $names[$i]['Email'] . '</td>';  //Table creation markup
							echo "<td><button id = '". $i . "' onclick= verifyUser('".$names[$i]['Id']."','".$names[$i]['Email']."')>This is me</button>"; //Tie user email and id to the UI button to send to AJAX function
							echo '</tr>';
							}
						echo '</table>';
						}
						else{
							echo '<script language="javascript">';
							echo 'alert("Name does not exist or you are already checked in!")';
							echo '</script>';
						}
					}
				}
			?>
		</div>
	</body>
</html>