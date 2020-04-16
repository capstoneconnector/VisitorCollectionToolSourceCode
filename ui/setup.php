<?php
	require_once "../php/classes/EventManager.php";
	session_start();
	$_SESSION["eventId"] = NULL;
	if(empty($_SESSION['logged'])){
		header ('location: login.php');
	}
?>
<html lang="php">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="/css/setup.css">

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<title>Set Up</title>
	</head>
	<body id = "main">
	<div class="container">
			<div class="row">
				<div class="col-12">
					<table width = "100%" style = "background:#05163D; color: honeydew" align="right">
						<tr>
							<td><img src="/img/Innovation_Connector_Logo.png" alt = "Logo" width="150px"></td>
							<td>
								<h2>Choose an Event</h2>
							</td>
							<td>&nbsp;</td>
							<td width = "10">&nbsp;</td>
						</tr>
					</table>
                </div>
                    <div class="col-2">
                        <div id ="menu">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href='manager.php'><span>Manager Dashboard</span></a></li>
                            </ul>
                        </div>
                    </div>
		<br><br><br><br>
                <div class="col-12">
		<form method="POST">
            <label for="placeholder"></label><select id = "placeholder" name="event" class="input" required>
				<option disabled selected> -- Select an event -- </option>
				<?php
					$events = EventManager::getSetupEvents();
					foreach($events as $event){
						echo "<option value='" . $event->getId() . "''>" . $event->getName() . " : " . $event->getDate() . "</option>";
					}
				?>
			</select>
			<br><br>
			<input type="submit" name="submit" class="submit">
		</form>
		<br><br><br>
		</div>
		</div>
        </div>
	</body>
</html>

<?php
	if (!empty($_POST["event"])) {
		$_SESSION["eventId"] = $_POST["event"];
		header('location: checkin.php');
	}
?>