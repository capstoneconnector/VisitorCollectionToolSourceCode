function verifyUser(userid, email, eventid) {
  console.log(email + userid);
	let confirmation = confirm("Check in user with email: " + email + "? By selecting “OK” the student and/or guardian agrees that the information provided on the " +
		"Student Sign In Sheet is true: Student’s name, Guardian’s name, Phone number, Person who drops off the student, " +
		"Person who will be picking up the student, and relation to the student if not the guardian. " +
		"Also, if the person picking up the student does change, the student’s guardian will notify the lead instructor for the event prior to pick up.");
	if(confirmation === true) {
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState === 4 && this.status === 200) { //If server returns correctly, callback function sets window back to checkin
				alert("Check in Successful");
				window.location = ("checkin.businessLogic");
			}
		};
		xhttp.open("GET", "/businessLogic/checkAttendeeIn.businessLogic?userid=" + userid + "&eventid=" + eventid, true); //AJAX call to checkEmail businessLogic script
		xhttp.send();
	}
}
