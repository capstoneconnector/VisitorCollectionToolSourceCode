function UpdateEvent()
	{
		var btnAddEvent = document.getElementById("btnAddEvent");
		var y = document.getElementById("SearchEvent");
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
	//hide other divs that are not needed

function UpdateAttendee() {
	var btnAddAttendee = document.getElementById("btnAddAttendee");
	var x = document.getElementById("UpdateAttendee");
	if (x.style.display === "none") {
		x.style.display = "block";
		btnAddAttendee.disabled = true;
	} else {
		x.style.display = "";
		btnAddAttendee.disabled = false;
	}
}

function UpdateUser() {
	var btnAddUsers = document.getElementById("btnAddUsers");
	var x = document.getElementById("UpdateUser");
	if (x.style.display === "none") {
		x.style.display = "block";
		btnAddUsers.disabled = true;
	} else {
		x.style.display = "none";
		btnAddUsers.disabled = false;
	}
}

//hide other divs

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

function exportTableToCSV(dbTable, tableName) {
	var csv = [];
	var rows = document.querySelectorAll("#" + dbTable + "Table tr");
	for (var i = 0; i < rows.length; i++) {
		var row = [], cols = rows[i].querySelectorAll("td, th");
		for (var j = 0; j < cols.length; j++)
			row.push(cols[j].innerText);
		csv.push(row.join(","));
	}
	// Download CSV file
	downloadCSV(csv.join("\n"), tableName);
}

function PullData() {
	let confirmation = confirm("Pull event data from EventBrite?");
	if (confirmation === true) {
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState === 4 && this.status === 200) {
				alert("EventBrite Pull Successful");
				window.location = ("manager.php");
			}
		};
		xhttp.open("GET", "/php/importEBEvents.php", true);
		xhttp.send();
	}
}

function SearchEvents() {
	let xhttp = new XMLHttpRequest();
	let query = document.getElementById("query").value;
	xhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) { //If server returns correctly, callback function sets window back to checkin
			document.getElementById("eventTable").innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "/php/displayQueriedEvents.php?query=" + query, true); //AJAX call to checkEmail php script
	xhttp.send();
}

function deleteEvent(eventid){
	let confirmation = confirm("Are you sure you want to delete this event? THIS IS IRREVERSIBLE!");
	if (confirmation === true) {
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState === 4 && this.status === 200) { //If server returns correctly, callback function sets window back to manager dashboard
				alert("Event Deleted!");
				window.location = ("manager.php");
			}
		};
		xhttp.open("GET", "/php/deleteEvent.php?eventid=" + eventid, true);
		xhttp.send();
	}
}

function deleteAttendee(attendeeid){
	let confirmation = confirm("Are you sure you want to delete this attendee? THIS IS IRREVERSIBLE!");
	if (confirmation === true) {
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState === 4 && this.status === 200) { //If server returns correctly, callback function sets window back to manager dashboard
				alert("Attendee Deleted!");
				window.location = ("users.php");
			}
		};
		xhttp.open("GET", "/php/deleteAttendee.php?attendeeid=" + attendeeid, true);
		xhttp.send();
	}
}

function editAttendee(){
	toggleTableEdit('true');
}

function saveAttendee(attendeeid){
	let confirmation = confirm("Save attendee information?");
	if (confirmation === true) {

		fname = document.getElementById('fname').innerHTML;
		lname = document.getElementById('lname').innerHTML;
		email = document.getElementById('email').innerHTML;
		phone = document.getElementById('phone').innerHTML;
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState === 4 && this.status === 200) { //If server returns correctly, callback function sets window back to manager dashboard
				alert("Attendee Saved!");
				toggleTableEdit('false');
			}
		};
		xhttp.open("GET", "/php/saveAttendee.php?userid=" + attendeeid + "&fname=" + fname + "&lname=" + lname + "&email=" + email + "&phone=" + phone, true);
		xhttp.send();
	}


}

function toggleTableEdit(toggle){
	const fields = [
		document.getElementById("fname"),
		document.getElementById("lname"),
		document.getElementById('email'),
		document.getElementById('phone')
	];

	for(let i = 0; i < fields.length; i++){
		fields[i].contentEditable = toggle;
		if(toggle === "true"){
			fields[i].className = "table-danger";
			fields[i].border = "5px";
		}
		else{
			fields[i].className = "";
			fields[i].border = "";
		}
	}
}

function toggleEmailForm(toggle){
	let x = document.getElementById("emailForm");
	let y = document.getElementById("SearchEvent");

	if (toggle === 'true') {
		x.style.display = "block";
		y.style.display = "none";
		document.getElementById("eventTable").style.display = "none";
	}
	else {
		window.location = ("manager.php");
	}
}

function showEventsInDateRange(){
	let startDate = document.getElementById("startDate").value;
	let endDate = document.getElementById("endDate").value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState === 4 && this.status === 200) { //If server returns correctly, callback function sets window back to manager dashboard
			document.getElementById("eventTable").style.display = "block";
			document.getElementById("eventTable").innerHTML = this.responseText;
			document.getElementById("sendEmail").style.display = "inline";
		}
	};
	xhttp.open("GET", "/php/displayEventEmailTable.php?startDate=" + startDate + "&endDate=" + endDate, true);
	xhttp.send();
}

function sendEmails(){
	let confirmation = confirm("Send thank you emails?");
	if (confirmation === true) {
		let checkboxes = document.getElementsByName("selectedEvents");
		let events = [];
		for (let i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].checked === true) {
				events.push(checkboxes[i].value);
			}
		}
		let eventsJson = JSON.stringify(events);
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState === 4 && this.status === 200) { //If server returns correctly, callback function sets window back to manager dashboard
				alert(this.responseText + " emails sent!")
			}
		};
		xhttp.open("GET", "/php/createEmailEvents.php?events=" + eventsJson, true);
		xhttp.send();
	}

}
