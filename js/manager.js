// adding record
// show div that has form
function UpdateEvent() 
	{
		var btnAddEvent = document.getElementById("btnAddEvent");
		var btnExport = document.getElementById("btnExport");
		var y = document.getElementById("SearchEvents");
		var x = document.getElementById("UpdateEvent");
		if (x.style.display === "")
		{
		x.style.display = "block";
		y.style.display = "none";
		btnAddEvent.disabled = true;
		}
		else 
		{
			x.style.display = "";
			y.style.display = "block";
			btnAddEvent.disabled = false;
		}
	}
	// maybe hide other divs that are not needed

	function downloadCSV(csv, filename) {
		var csvFile;
		var downloadLink;

		// CSV file
		csvFile = new Blob([csv], {type: "text/csv"});

		// Download link
		downloadLink = document.createElement("a");

		// File name
		downloadLink.download = filename;

		// Create a link to the file
		downloadLink.href = window.URL.createObjectURL(csvFile);

		// Hide download link
		downloadLink.style.display = "none";

		// Add the link to DOM
		document.body.appendChild(downloadLink);

		// Click download link
		downloadLink.click();
	}

	function exportTableToCSV(filename) {
	var csv = [];
	var rows = document.querySelectorAll("#AttendeeTable tr");
	for (var i = 0; i < rows.length; i++) {
		var row = [], cols = rows[i].querySelectorAll("td, th");
		for (var j = 0; j < cols.length; j++) 
			row.push(cols[j].innerText);
		csv.push(row.join(","));
	}
	// Download CSV file
	downloadCSV(csv.join("\n"), filename);
}