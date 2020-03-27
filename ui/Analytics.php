<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src = "/js/manager.js"></script>
    <link rel = "stylesheet" type = "text/css" href = "/css/Analytics.css">
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});
        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);
        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
    <?php
    require_once "../php/getAttendanceInfo.php";
    require_once "../php/getGenderInfo.php";
    if (isset($_GET["eventid"])) {
        $attendance = getAttendanceProportion($_GET["eventid"]);
        $walkinProportion = $attendance['walkin'] / $attendance['registered'];
        $attendedProportion = $attendance['attended'] / $attendance['registered'];
        echo "function drawChart() {";
        echo "var data = new google.visualization.DataTable();";
        echo "data.addColumn('string', 'Type');";
        echo "data.addColumn('number', 'Attendance');";
        echo "data.addRows([";
        echo "['Walk-in', ".$walkinProportion. "],";
        echo "['Attended', ". $attendedProportion."],";
        echo " ]);";
        echo "var options = {'title':'Attendance Types',";
        echo "vAxis : {format: 'percent', viewWindow : {min : 0}},";
        echo "'width':800,";
        echo "'height':600};";
        echo "var chart = new google.visualization.PieChart(document.getElementById('Attendance_Proportions'));";
        echo "chart.draw(data, options);";
        echo "}";
    }

    if (isset($_GET["eventid"])) {
        $gender = getGenderDifferences($_GET["eventid"]);
        $femaleProportion = $gender['Female'];
        $maleProportion = $gender['Male'];
        $otherProportion = $gender['Other'];
        echo "function drawChart() {";
        echo "var data = new google.visualization.DataTable();";
        echo "data.addColumn('string', 'Type');";
        echo "data.addColumn('number', 'Genders');";
        echo "data.addRows([";
        echo "['Female', ".$femaleProportion. "],";
        echo "['Male', ". $maleProportion."],";
        echo "['Prefer not to say', ". $otherProportion."],";
        echo " ]);";
        echo "var options = {'title':'Gender Types',";
        echo "vAxis : {format: 'percent', viewWindow : {min : 0}},";
        echo "'width':800,";
        echo "'height':600};";
        echo "var chart = new google.visualization.ColumnChart(document.getElementById('Gender_Differences'));";
        echo "chart.draw(data, options);";
        echo "}";
    }

    ?>
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <title>Manager Dashboard</title>
</head>
<body>
<div class = "container">
    <div class = "row">
        <div class="col-12">
            <table width = "100%" style = "background:#05163D; color: honeydew" align="right">
                <tr>
                    <td><img src="/img/Innovation_Connector_Logo.png" alt = "Logo" width="150px"></td>
                    <td width = "20">&nbsp;</td>
                    <td>
                        <h2>Analytics</h2>
                    </td>
                    <td width = "285">&nbsp;</td>
                </tr>
            </table>
        </div>
        <div class="col-2">
            <div id ="menu">
                <ul>
                    <li><a href='setup.php'><span>Set Up</span></a></li>
                    <li class='last'><a href='manager.php'><span>Events</span></a></li>
                </ul>
            </div>
        </div>
        <!--Div that will hold the pie chart-->
        <div id="Attendance_Proportions">
        </div>
        <div id="Gender_Differences">
        </div>
    </div>
</div>
</body>
</html>