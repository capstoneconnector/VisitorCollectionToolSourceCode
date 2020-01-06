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
				<img src="/img/Innovation Connector Logo.png" width="150px"></img>
				<div id ="menu">
					<ul>
						<li><a href='setup.php'><span>Set Up</span></a></li>
						<li><a href='Analytics.php'<span>Analytics</span></a></li>
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
							<button id = "btnExport" class = "btn btn-info" onclick = exportTableToExcel('EventTable');> Export </button>
						</td>
						<td width = "10">&nbsp;</td>
					</tr>
					<tr>
						<td colspan "2"></td>
					</tr>
				</table>
			</div>
			<div class="col-10">
				<div id="UpdateEvent" class = "col-7">
				<label>Name:</label><input type="text" name="name"/>
				<br />
				<label>Description:</label><input type="text" name="description"/>
				<br />
				<label>Date:</label><input type="text" name="date"/>
				<br />
				<label>PIN:</label><input type="text" name="pin"/>
				<br />
				<button onclick="AddForm">Save</button>
				<button onclick="UpdateEvent();">Cancel</button>
				</div>
			<div id = "SearchEvents">
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
			include_once $root . "/db/connect.php";
			$stmt = $pdo->prepare("SELECT * from event");
					if ($stmt -> execute())
					{
					echo "<table id = 'EventTable' class='table'>";
					echo '<thead class="thead-dark">';
					echo "<tr>";
						echo "<th>Name</th>";
						echo "<th>Description</th>";
						echo "<th>Date</th>";
						echo "<th>Eventid</th>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
						while($row = $stmt -> fetch())
						{
							echo "<tr>";
							echo "<td>".$row['Name']."</td>";
							echo "<td>".$row['Date']."</td>";
							echo "<td>".$row['Eventid']."</td>";
							//echo "<td>"."<button onclick = EditEvent('1')>Edit</button>";
							//echo "<td>"."<button onclick = DeleteEvent('1')>Delete</button>";
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