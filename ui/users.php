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
							<td align = "right">
								<button id = "btnAddUsers" class = "btn btn-info" onclick = "UpdateUser();"> Add  </button>
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
				    <form method = "post" id="UpdateUser" class="col-7" style="display:none">
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
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="other">Prefer not to say</option>
                        </select>
                        <br><br>
                        <input type = "submit" value = "Save">
                        <button onclick="UpdateUser();">Cancel</button>
                    </form>
                </div>
                <br>
                <div id = "AttendeeTable" class="col-12">
                    <?php
                    require_once "../businessLogic/classes/AttendeeManager.php";
                    $attendees = AttendeeManager::getAllAttendees();
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
                        foreach($attendees as $attendee) {
                            echo "<tr>";
                            echo "<td ><a href = 'attendee.businessLogic?attendeeid=" . $attendee->getId() . "'>" . $attendee->getFirstName() . "</a></td>";
                            echo "<td><a href = 'attendee.businessLogic?attendeeid=" . $attendee->getId() . "'>" . $attendee->getLastName() . "</a></td>";
                            echo "<td>" . $attendee->getEmail() . "</td>";
                            echo "<td>" . $attendee->getPhone() . "</td>";
                            echo "<td>" . $attendee->getGender() . "</td>";
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

<?php
require_once "../businessLogic/classes/AttendeeManager.php";

if (!empty($_POST))
{
    if (isset($_POST['fname']))
    {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $gender = $_POST["gender"];
        if($gender == "other"){
            $gender = NULL;
        }
        if(!AttendeeManager::checkAttendeeExists($fname, $lname, $email)){
            $attendee = AttendeeManager::createAttendee($fname, $lname, $email, $gender, $phone);
            echo '<script language="javascript">';
            echo 'window.location=("users.businessLogic");';
            echo '</script>';
        }
        else{
            echo '<script language="javascript">';
            echo 'alert("Attendee already exists!");';
            echo '</script>';
        }
    }
}
?>