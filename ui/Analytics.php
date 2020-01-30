<html>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src = "/js/Analytics.js"></script>
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
		function drawChart() {
		// Create the data table.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Topping');
		data.addColumn('number', 'Slices');
		data.addRows([
			['Mushrooms', 3],
			['Onions', 1],
			['Olives', 1],
			['Zucchini', 1],
			['Pepperoni', 2]
		]);
		// Set chart options
		var options = {'title':'This is an example chart',
						'width':400,
						'height':300};
		// Instantiate and draw our chart, passing in some options.
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		chart.draw(data, options);
		}
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
			<div class="col-2">
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
							<h2>Analytics</h2>
						</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</div>
				<!--Div that will hold the pie chart-->
					<div id="chart_div">
					</div>
		</div>
	</div>
	</body>
</html>