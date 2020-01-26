<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src = "/js/manager.js"></script>
		<link rel = "stylesheet" type = "text/css" href = "/css/manager.css">

		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<title>Manager Dashboard</title>
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<div class="col-2">
					<img src="/img/Innovation_Connector_Logo.png" width="150px"></img>

					
						<div id ="menu">
							<ul class="nav nav-pills nav-stacked">
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
								<button id = "btnAddEvent" class = "btn btn-info" onclick = PullData(-1);> Pull API </button>
								<button id = "btnAddEvent" class = "btn btn-info" onclick = AddAttendee(-1);> Add Attendee </button>
							</td>
							<td width = "10">&nbsp;</td>
						</tr>
						<tr>
							<td colspan "2"></td>
						</tr>
					</table>
				</div>
				
			<div class="col-10">
				<form method = "post" div id="UpdateEvent" class = "col-7">
				<label>Name:</label>
				</br>
				<input type="text" name="name" required />
				</br>
				<label>Description:</label>
				</br>
				<textarea rows=5 cols=25></textarea>
				</br>
				<label>Date:</label>
				</br>
				<input type="text" name="date" required />
				</br></br>
				<input type = "submit" value = "Save">
				<button onclick="UpdateEvent();">Cancel</button>
				</div>
				</form>
			<div id = "SearchEvents" class="col-9">
				<form>
					<div class = "col-10 float-left">
						<label for = "Search" class "control-label"> Search</label>
						<input type = "text" class = "form-control" />
					</div>
					<div class = "col-1 float-right">
						<label>EventId: </label>
						<input type="text" name="EventId" />
						</br></br>
						<button id = "btnAddEvent" class = "btn btn-info" onclick = ExportAttendeeID;> Export </button>
					</div>
			</div>
				</form>
		</div>
			<div id = "EventTable" class="col-12">
			<?php
				$root = $_SERVER['DOCUMENT_ROOT'];
				include_once $root . "/db/getEventInfo.php";
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
			</div>
		</div>
	</tbody>
	</div>
	</div>
	
	</body>
</html>
<?php
	include_once $root . "/db/addEvent.php";
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