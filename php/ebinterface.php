<?php
$api_key = "2GEOZ7XABZBZWS46A3";
$pri_token = "COKR3D7YQAPZM2GWLOTL";
$pub_token = "UKQY46DJTOTSARNGUAWH";
$event_ID = "86470394277";
//header("Authorization: Bearer ".$pri_token);

function retrieveData($url) {
	echo 	"<u>".$url."</u><br>";
	$contents = file_get_contents($url);
	echo $contents."<br><br>";
	return $contents;
}

function wrapRequest($request, $args) {
	static $endpoint = "https://www.eventbriteapi.com/v3/";
	static $my_token = "?token=COKR3D7YQAPZM2GWLOTL";
	return $endpoint.$request.$my_token.$args;
}

$my_events_url = wrapRequest("users/me/events", "");						//get all events' details
$event_list_url = wrapRequest("events/".$event_ID, ""); 					//get one event's details
$attendee_list_url = wrapRequest("events/".$event_ID."/attendees/", "");	//get the attendee list for a spesific event

retrieveData($my_events_url);
retrieveData($event_list_url);
retrieveData($attendee_list_url);

?>


<html>
	<head></head>
	<body>
		<a href="../ui/setup.php">Setup page</a>
		<br>
	</body>

</html>