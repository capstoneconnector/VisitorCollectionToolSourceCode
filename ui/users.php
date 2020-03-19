<html lang="php">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src = "/js/manager.js"></script>
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<link rel = "stylesheet" type = "text/css" href = "/css/manager.css">

		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<title>User Information</title>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<table width = "100%" style = "background:#05163D; color: honeydew" align="right">
						<tr>
                            <td>
                                <img src="/img/Innovation_Connector_Logo.png" alt = "Logo" width="150px">
                            </td>
							<td width = "20">&nbsp;</td>
							<td>
								<h2>Users</h2>
							</td>
							<td>&nbsp;</td>

							<td align = "right">
								<button id = "btnEditUsers" class = "btn btn-info" onclick = EditUsers(-1);> Edit </button>
								<button id = "btnAddUsers" class = "btn btn-info" onclick = UpdateUser (-1);> Add  </button>
							</td>
							<td width = "10">&nbsp;</td>
						</tr>
						<tr>
							<td colspan "2">
						</tr>
					</table>
				</div>
                <div class="col-2">
                    <div id ="menu">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href='setup.php'><span>Set Up</span></a></li>
                            <li><a href='manager.php'><span>Events</span></a></li>
                        </ul>
                    </div>
                </div>
			    <div class="col-10">
				    <form method = "post" id="UpdateUser" class="col-7">
                        <label>First Name:</label>
                        <br>
                        <label>
                            <input type="text" name="fname" required />
                        </label>
                        <br>
                        <label>Last Name:</label>
                        <br>
                        <label>
                            <input type="text" name="lname" required />
                        </label>
                        <br>
                        <label>Email:</label>
                        <br>
                        <label>
                            <input type="email" name="email" required />
                        </label>
                        <br>
                        <label>Phone Number:</label>
                        <br>
                        <label>
                            <input type="text" name="phone" required />
                        </label>
                        <br>
                        <label for="placeholder"></label><select id = "placeholder" name="gender" class="input" required>
                            <option disabled selected> -- Gender -- </option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Prefer not to say</option>
                        </select>
                        <br><br>
                        <input type = "submit" value = "Save">
                        <button onclick="UpdateAttendee();">Cancel</button>
                    </form>
                </div>
                <br>
                <div id = "SearchUsers" class="col-12">
                    <form name = "searchForm" id = "searchForm" method="post">
                        <div class="col-7 float-left">
                            <label for = "Search" class = "control-label">Search Events:</label>
                            <span><input type = "text" name = "query" id = "query" class = "form-control" /></span>
                        </div>
                    </form>
                    <div class="col-5 float-right">
                        <div class="col-4 float-right">
                            <form action="" method="post">
                                <button name = "reset" class = "btn btn-info">Reset</button>
                            </form>
                            <br><br>
                        </div>
                        <button onclick = 'SearchUsers(-1)' class = "btn btn-info">Search</button>
                    </div>
                </div>
                <div id = "AttendeeTable" class="col-12">
                    <?php
                    require_once "../php/getAttendeeInfo.php";
                    $attendees = getAllAttendees();
                    if (!empty($attendees)){
                        echo "<div id = 'header'>Attendees</div>";
                        echo "<br>";
                        echo "<table id = 'attendeeTable' class='table'>";
                        echo '<thead class="thead-dark">';
                        echo "<tr>";
                        echo "<th>First Name</th>";
                        echo "<th>Last Name</th>";
                        echo "<th>Email</th>";
                        echo "<th>Phone Number</th>";
                        echo "<th>Gender</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        foreach($attendees as $attendee){
                            echo "<tr>";
                            echo "<td><a href = 'attendee.php?attendeeid=".$attendee->getId()."'>".$attendee->getFirstName()."</a></td>";
                            echo "<td><a href = 'attendee.php?attendeeid=".$attendee->getId()."'>".$attendee->getLastName()."</a></td>";
                            echo "<td>" . $attendee->getEmail() . "</td>";
                            echo "<td>" . $attendee->getPhone() . "</td>";
                            echo "<td>" . "TODO" . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>