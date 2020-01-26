<?php
$API_KEY = "2GEOZ7XABZBZWS46A3";
$PRI_TOKEN = "COKR3D7YQAPZM2GWLOTL";
$PUB_TOKEN = "UKQY46DJTOTSARNGUAWH";
$EVENT_ID = "86470394277";
//header("Authorization: Bearer ".$pri_token); // If we can make this work, This would make some things simpler.

/*
arg: $requeset is the url extention after the endpoint
arg: $data is extra aruments in the url. Must be a list of arguments eg ["arg=value", ...]
*/
function wrapRequestWtihData($request, $data) {
	static $endpoint = "https://www.eventbriteapi.com/v3/";
	static $my_token = "?token=COKR3D7YQAPZM2GWLOTL";

	$args = "";
	foreach ($data as $arg) {
		$args += "?".$arg;
	}

	return $endpoint.$request.$my_token.$args;
}

function wrapRequest($request) {
	return wrapRequestWtihData($request, []);
}

function getJsonFromURL($url) {
	return json_decode(file_get_contents($url), true);
}

function pullEbEvents($OAuthToken) {
	$contents = getJsonFromURL(wrapRequest("users/me/events"));
	$events = $contents["events"];
	//add pagination
	return $events;
}

function pullEbAttendees($event_id) {
	$contents = getJsonFromURL(wrapRequest("events/".$event_id."/attendees/"));
	$attendees = $contents["attendees"];
	//add pagination
	return $attendees;
}

function importEbEvents($oAuthToken) {
	require_once "../db/dbInterface.php";

	$events = pullEbEvents($oAuthToken);
	foreach ($events as $event) {
		addEvent($event["name"], $event["start"]["local"]);

		$attendees = pullEbAttendees($event["id"]);
		foreach ($attendees["attendees"] as $attendee) {
			$profile = $attendee["profile"];
			addAttendee($profile["first_name"], 
						$profile["last_name"],
						$profile["email"],
						$attendee["event_id"]
			);
			
		}
	}
}


function testPullEbEvents() {
	echo $attendee_list_url;
	echo "<br>";
	$events = pullEbEvents($PRI_TOKEN);

	$attendees = pullEbAttendees($events[0]["id"]);
	$attendee = $attendees[0];
	echo $attendee["profile"]["name"];
	echo "<br>";
	echo $attendee["id"];
	echo "<br>";	
}

function testPullEbEvents() {
	$events = pullEbEvents($PRI_TOKEN);
	echo $events[0]["name"];
	echo "<br>";
	echo $events[0]["id"];
	echo "<br>";
	echo $events[0]["event_url"];
	echo "<br>";
}
?>


<html>
	<head></head>
	<body>
		https://www.eventbriteapi.com/v3/users/me/events?token=COKR3D7YQAPZM2GWLOTL
		pullEbEvents($OAuthToken) //Pri_token get all of the events of a user<br>
		getAttendees($event_id) // get a list of all attendees' full name and email "fullname": "email" or 0 = {"name": <\fullname>, "email": <\email>}<br>
		getAttendeeInfo($attendee_id) // return entire attendee object<br>


		https://www.eventbriteapi.com/v3/users/me/events?token=OAUTH_TOKEN				//get all events' details
		https://www.eventbriteapi.com/v3/events/EVENT_ID?token=OAUTH_TOKEN				//get one event's details
		https://www.eventbriteapi.com/v3/events/EVENT_ID/attendees/?token=OAUTH_TOKEN	//get the attendee list for a spesific event

	</body>

</html>