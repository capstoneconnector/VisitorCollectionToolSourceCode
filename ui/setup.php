<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="/js/checkin.js"></script>
		<title>Setup event</title>
	</head>

	<body>
		<p>Setup the event</p>
		<br><br>

		<form action="checkin.php" method="POST">
			<select name="event">
				<!-- Options need to be replaced with actual data from DB-->
				<option value="event1">Event 1</option>
				<option value="event2">Event 2</option>
			</select>
			<input type="hidden" name="name" value="">
			<input type="submit" name="submit">
		</form>

		<a href="../php/ebinterface.php">ebinterface</a>
	</body>
</html>