<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src = "/js/manager.js"></script>
		<link rel = "stylesheet" type = "text/css" href = "/css/manager.css">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<body>
	<div class="container">
		<div class="row">
			<div class="col-2">
		<title>Manager Dashboard</title>
	</head>
				<img src="/img/Innovation_Connector_Logo.png" width="150px"></img>
				<div id ="menu">
					<ul>
						<li><a href='setup.php'><span>Set Up</span></a></li>
						<li class='last'><a href='manager.php'><span>Events</span></a></li>
					</ul>
				</div>
			</div>
			<div class="col-10">
				<table width = "100%" style = "background:#05163D; color: honeydew" align="right">
					<tr>
						<td width = "20">&nbsp;</td>
						<td>
							<h2>Events</h2>
						</td>
						<td>&nbsp;</td>
						<td align = "right">
							<button id = "btnAddEvent" class = "btn btn-info" onclick = UpdateEvent(-1);> Add New Event </button>
						</td>
						<td width = "10">&nbsp;</td>
					</tr>
					<tr>
						<td colspan "2"></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-10">
				<form method = "post" div id="UpdateEvent" class = "col-7">
				<label>Name:</label>
				</br>
				<input type="text" name="name" required />
				</br>
				</br>
				<label>Date:</label>
				</br>
				<input type="text" name="date" required />
				</br></br>
				<input type = "submit" value = "Save">
				<button onclick="UpdateEvent();">Cancel</button>
				</div>
				</form>
			<div id = "SearchEvents" class = "col-10">
				<form>
					<div class="col-sm">
						<label for = "Search" class "control-label"> Search</label>
					</div>
					<div class="col-sm">
						<input type = "text" class = "form-control" />
					</div>
				</form>
			<?php
				$root = $_SERVER['DOCUMENT_ROOT'];
				require_once $root . "/db/getEventInfo.php";
				$events = getAllEvents();
				if (!empty($events)){
					echo "<table id = 'EventTable' class='table'>";
					echo '<thead class="thead-dark">';
					echo "<tr>";
					echo "<th>Name</th>";
					echo "<th>Date</th>";
					echo "<th>Eventid</th>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
					foreach($events as $row){
						echo "<tr>";
						echo "<td>".$row['Name']."</td>";
						echo "<td>".$row['Date']."</td>";
						echo "<td>".$row['Eventid']."</td>";
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
				}
			?>
			</div>
		</div>
	</tbody>
	</div>
	</div>
	
	</body>
</html>
<?php
	require_once $root . "/db/addEvent.php";
	if (!empty($_POST))
	{
		$name = $_POST["name"];
		$description = $_POST["description"];
		$date = $_POST["date"];
		if (addEvent($name, $date)){
			echo '<script language="javascript">';
			echo 'window.location=("manager.php")';
			echo '</script>';
		}

		else{
			echo '<script language="javascript">';
			echo 'alert("DB Error"))';
			echo '</script>';
		}
	}
?>