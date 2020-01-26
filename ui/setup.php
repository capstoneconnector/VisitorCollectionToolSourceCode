<?php
	require_once "../db/dbInterface.php";
	session_start();

	if (isset($_POST["event"])) {
		$_SESSION["eventId"] = $_POST["event"];
		header("Location: checkin.php");
	}
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="/css/setup.css">

		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

		<body id ="main">
		<div class="container">
		<div class="row">
			<div class="col-2">
		<title>Event Setup</title>
	</head>
			<img src="/img/Innovation_Connector_Logo.png" width="150px"></img>
				<div id ="menu">
					<ul>
						<li><a href='Analytics.php'><span>Analytics</span></a></li>
						<li class='last'><a href='manager.php'><span>Manager</span></a></li>
					</ul>
				</div>
			</div>
			<div class="col-10">
				<table width = "100%" style = "background:#05163D; color: honeydew" align="right">
					<tr>
						<td width = "20">&nbsp;</td>
						<td>
							<h2>Choose an Event</h2>
						</td>
						<td width = "10">&nbsp;</td>
					</tr>
					<tr>
						<td colspan "2"></td>
					</tr>
					</tr>
				</table>
				</br></br></br></br>
						<form method="POST">
							<select id = "placeholder" name="event" class="input" required>
							<option disabled selected> -- Select an event -- </option>
						<?php
						$events = getAllEvents();
						foreach($events as $event){
							echo "<option value='" . $event["Eventid"] . "''>" . $event["Name"] . " : " . $event["Date"] . "</option>";
						}
						?>
							</select>
					<br><br>
						<input type="submit" name="submit" class="submit">
						</form>
					<br><br><br>
					<button class="submit" onclick="window.location = 'manager.php'">Manager Page</button>
			</div>
		</div>
		</div>
	</body>
</html>