function register(){
	window.location = ('register.php');
}

function verifyUser(email) {
  var confirmation = confirm("Check in user with email: " + email + "?");
  if(confirmation == true){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       alert("Check in Successful");
       window.location = ('checkin.php');
      }
    };
    xhttp.open("GET", "checkEmail.php?email=" + email, true);
    xhttp.send();
  }
  }