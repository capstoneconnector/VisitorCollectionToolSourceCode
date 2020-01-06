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

	function exportTableToExcel(tableID, filename = '')
	{
		var downloadLink;
		var dataType = 'application/vnd.ms-excel';
		var tableSelect = document.getElementById(tableID);
		var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
		
		// Specify file name
		filename = filename?filename+'.xls':'excel_data.xls';
		// Create download link element
		downloadLink = document.createElement("a");
		document.body.appendChild(downloadLink);
		if(navigator.msSaveOrOpenBlob)
		{
			var blob = new Blob(['\ufeff', tableHTML], 
			{
				type: dataType
			});
			navigator.msSaveOrOpenBlob( blob, filename);
		}
		else
		{
			// Create a link to the file
			downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
			// Setting the file name
			downloadLink.download = filename;
			//triggering the function
			downloadLink.click();
		}
	}
