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
		<title>Event Setup</title>
	</head>

	<body id = "main">
		<br>
		<h1>Choose an Event</h1>
		<br>
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
	</body>
</html>