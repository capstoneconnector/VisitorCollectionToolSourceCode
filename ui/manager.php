<?php
	session_start();
	if(empty($_SESSION['logged'])){
		header ('location: login.php');
	}
	if(empty($_SESSION['reset'])){
	    $_SESSION['reset'] = TRUE;
    }
?>

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
		<title>Manager Dashboard</title>
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
								<h2>Events</h2>
							</td>
							<td>&nbsp;</td>

							<td align = "right">
								<button id = "btnAddEvent" class = "btn btn-info" onclick = UpdateEvent(-1);> Add New Event </button>
								<button id = "btnAddData" class = "btn btn-info" onclick = PullData(-1);> Pull API </button>
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
                        </ul>
                    </div>
                </div>
			    <div class="col-10">
				    <form method = "post" id="UpdateEvent" class="col-7">
                        <label>Name:</label>
                        <br>
                            <label>
                                <input type="text" name="name" required />
                            </label>
                            <br>
                        <label>Description:</label>
                        <br>
                        <label>
                            <textarea name = "description" form = "UpdateEvent" rows=5 cols=25></textarea>
                        </label>
                        <br>
                        <label>Date (YYYY-MM-DD):</label>
                        <br>
                        <label>
                            <input type="text" name="date" required />
                        </label>
                        <br><br>
                        <input type = "submit" value = "Save">
                        <button onclick="UpdateEvent();">Cancel</button>
                        <br><br>
				    </form>
                </div>
                <br>
                <div id = "SearchEvents" class="col-12">
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
                        <button onclick = 'SearchEvents(-1)' class = "btn btn-info">Search</button>
                    </div>
                </div>
			</div>
        </div>
			<?php
				require_once "../php/getEvents.php";
                function createEventTable($events){
                    echo "<div class = 'container'>";
                    echo '<div id = "EventTable" class="col-12">';
                    echo "<table id = 'eventTable' class='table'>";
                    echo '<thead class="thead-dark">';
                    echo "<tr>";
                    echo "<th>Name</th>";
                    echo "<th>Description</th>";
                    echo "<th>Date</th>";
                    echo "<th>Eventid</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    foreach($events as $event){
                        echo "<tr>";
                        echo "<td><a href = 'event.php?eventid=".$event->getId()."'>".$event->getName()."</a></td>";
                        echo "<td>".$event->getDescription()."</td>";
                        echo "<td>".$event->getDate()."</td>";
                        echo "<td>".$event->getId()."</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                    echo "</div>";
                }
				$events = getAllEvents();
				if (!empty($events) and $_SESSION['reset'] == TRUE){
					createEventTable($events);
				}
			?>
        </div>
    </body>
</html>

<?php
	require_once "../php/createEvent.php";
    require_once "../php/getEvents.php";
	if (!empty($_POST))
	{
        if(isset($_POST['reset'])){
            $_SESSION['reset'] = TRUE;
        }

		elseif (isset($_POST['name']))
		{
            $name = $_POST["name"];
            $description = $_POST["description"];
            $date = $_POST["date"];
            if(preg_match("/\d\d\d\d-[0-1][0-9]-[0-3][0-9]/", $date))
            {
                if (createEvent($name, $description, $date)){
                echo '<script language="javascript">';
                echo 'window.location=("manager.php")';
                echo '</script>';
                }
                else
                {
                echo '<script language="javascript">';
                echo 'alert("Date Format Error: YYYY-MM-DD"))';
                echo '</script>';
                }
            }
                if (isset($_POST["export"]))
                {
                    echo '<script language="javascript">';
                    echo 'exportTableToCSV("event", "event.csv")';
                    echo '</script>';
                }
		}
	}
?>