<html lang="php">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src = "/js/manager.js"></script>
    <link rel = "stylesheet" type = "text/css" href = "/css/manager.css">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <title>Attendee Information</title>
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
                        <td>
                            <h2>Attendee Information</h2>
                        </td>
                        <td align = "right">
                            <button id = "editAttendee" class = "btn btn-info" onclick = editAttendee(-1);> Edit </button>
                            <?php
                            $attendeeId = $_GET["attendeeid"];
                            echo '<button id = "btnDeleteAttendee" class = "btn btn-info" onclick = deleteAttendee("' . $attendeeId . '")> Delete Attendee </button>';
                            ?>
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
                    <li class='last'><a href='manager.php'><span>Events</span></a></li>
                </ul>
            </div>
        </div>
        </div>
        <div class = "col-12">
            <?php
            require_once "../php/getAttendeeInfo.php";
            if (isset($_GET["attendeeid"]))
            {
                $attendee = getAttendeeInfoByID($_GET["attendeeid"]);
                unset($_POST["attendeeid"]);
            }
            if (!empty($attendee)){
                echo "<div id = 'header'>" . $attendee->getFirstName() . " " . $attendee->getLastName() . "</div>";
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
                echo "<tr>";
                echo "<td contenteditable='true'>" . $attendee->getFirstName() . "</td>";
                echo "<td contenteditable='true'>" . $attendee->getLastName() . "</td>";
                echo "<td contenteditable='true'>" . $attendee->getEmail() . "</td>";
                echo "<td contenteditable='true'>" . $attendee->getPhone() . "</td>";
                echo "<td contenteditable='true'>" . $attendee->getGender() . "</td>";
                echo "</tr>";
                echo "</tbody>";
                echo "</table>";
            }
            ?>
    </div>
</div>
</body>
</html>