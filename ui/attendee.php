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
					<img src="../img/Innovation_Connector_Logo.png" width="150px"></img>
					
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
								<h2>Attendees</h2>
							</td>
							<td>&nbsp;</td>
							
							<td align = "right">
								<button id = "btnAddAttendee" class = "btn btn-info" onclick = AddAttendee(-1);> Add Attendee </button>
							</td>
							<td width = "10">&nbsp;</td>
						</tr>
						<tr>
							<td colspan "2"></td>
						</tr>
					</table>
				</div>
			<div class="col-10">
				<form method = "post" div id="AddAttendee" class = "col-7">
				<label>First Name:</label>
				</br>
				<input type="text" name="fname" required />
				</br>
				<label>Last Name:</label>
				</br>
				<input type="text" name="lname" required />
				</br>
				<label>Email:</label>
				</br>
				<input type="text" name="email" required />
				
				</br></br>
				<input type = "submit" value = "Save">
				<button onclick="AddAttendee();">Cancel</button>
				</div>
				</form>
			<div id = "SearchAttendee" class="col-9">
				<form method="post">
					<div class="col-12">
						<div class = "col-10 float-left">
							<label for = "Search" class "control-label"> Search</label>
							<input type = "text" class = "form-control" />
							</br>
						</div>
						<div class = "col-2 float-right">
							</br>
							<button type="submit" name="export" class = "btn btn-info"> Export </button>
							</br>
						</div>
					</div>
			</div>
				</form>
		</div>
			<div id = "AttendeeTable" class="col-12">
			<?php
				require_once "../db/dbInterface.php";
				
				$attendees = [];
				if (isset($_GET["eventid"])) {
					$attendees = getAttendeeInfoByEventId($_GET['eventid']);
					unset($_POST["eventid"]);
				}
				if (!empty($attendees)){
					echo "<table id = 'attendeeTable' class='table'>";
					echo '<thead class="thead-dark">';
					echo "<tr>";
					echo "<th>Fname</th>";
					echo "<th>Lname</th>";
					echo "<th>Email</th>";
					echo "<th>Phone</th>";
					echo "<th>Attended</th>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
					foreach($attendees as $attendee){
						echo "<tr>";
						echo "<td>".$attendee['Fname']."</td>";
						echo "<td>".$attendee['Lname']."</td>";
						echo "<td>".$attendee['Email']."</td>";
						echo "<td>".$attendee['Phone']."</td>";
						echo "<td>".$attendee['Attended']."</td>";
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
	require_once "../db/dbInterface.php";
	if (!empty($_POST))
	{
		if (isset($_POST['name']))
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
	if (isset($_POST["export"]))
		{
			echo '<script language="javascript">';
			echo 'exportTableToCSV("attendee", "attendee.csv")';
			echo '</script>';
			unset($_POST["export"]);
		}
	}	
?>