<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="/css/setup.css">
		<title>Event Setup</title>
	</head>

	<body id = "main">
		<h1>Event Setup</h1>
		<br>
		<form action="checkin.php" method="POST">
			<select name="event" class = "input">
				<option disabled selected value> -- Select an event -- </option>";
				<!-- Options need to be replaced with actual data from DB-->
				<option value="event1">Event 1</option>
				<option value="event2">Event 2</option>
			</select>
			<input type="hidden" name="name" value="">
			<br><br>
			<input type="submit" name="submit" class = "submit">
		</form>

		<a href="../php/ebinterface.php">ebinterface</a>
	</body>
</html>