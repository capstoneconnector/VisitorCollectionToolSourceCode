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
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-2">
				<title>Check In</title>
	</head>
					<div class="panel-group" id="menu">
						<div class="panel panel-default">
							<div class="panel-heading">
							<h4 class="panel-title">
							<a data-toggle="collapse" href="#collapse1"></a>
							</h4>
							</div>
							<ul>
						<div id="collapse1" class="panel-collapse collapse">
						<div class="panel-body"><li><a href='setup.php'><span>Set Up</span></a></li></div>
						<div class="panel-footer"><li class='last'><a href='register.php'><span>Registration</span></a></li></div>
						</ul>
						</div>
						</div>
					</div>
					</div>
				</div>
				<div id="main">
					<div class="col-10">
						<table width = "100%" style = "background:#05163D; color: honeydew" align="right">
							<tr>
								<td width = "20">&nbsp;</td>
								<td>
								<h2>Check In</h2>
								</td>
								<td>&nbsp;</td>
								<td width = "10">&nbsp;</td>
							</tr>
							<tr>
								<td colspan "2"></td>
							</tr>
						</table>
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
				<input class="submit" type="submit" value="Check In">
				<br><br>
			</form>
			<button class="submit" onclick="window.location = 'setup.php'"><img src="../img/home_icon.png" alt="home icon" height="32"></button>
		</div>
		</div>
		<br><br><br>
		<div class="table">
			<?php
				$root = $_SERVER['DOCUMENT_ROOT'];
				include_once $root . "/php/findName.php";
				$event = $_SESSION['eventId'];
				if(!empty($_POST)){
					if(!empty($_POST["name"])){
						$name = $_POST["name"];
						$names = findName($name, $event); //Fetch names that match name entered by user
						if(!empty($names)){ //Only creates table if there is content to write to it
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