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

function getAllEvents($OAuthToken) {
	$contents = getJsonFromURL(wrapRequest("users/me/events"));
	$events = $contents["events"];
	
	$event_list = [];

	$event_num = 0;
	foreach ($events as $event) {
		$event_list[$event_num] = array("name"=>$event["name"]["text"], 
										"id"=>$event["id"], 
										"event_url"=>$event["url"], 
										"ticket_url"=>$event["resource_uri"]
										);
		$event_num++;
	}
	return $events;
}

function getAllAttendees($event_id) {
	$contents = getJsonFromURL(wrapRequest("events/".$event_id."/attendees/"));
	$attendees = $contents["attendees"];
	//add pagination
	return $attendees;
}


$my_events_url = wrapRequest("users/me/events");						//get all events' details
$event_list_url = wrapRequest("events/".$EVENT_ID); 					//get one event's details
$attendee_list_url = wrapRequest("events/".$EVENT_ID."/attendees/");	//get the attendee list for a spesific event


function testGetAllEvents() {
	echo $attendee_list_url;
	echo "<br>";
	$events = getAllEvents($PRI_TOKEN);

	$attendees = getAllAttendees($events[0]["id"]);
	$attendee = $attendees[0];
	echo $attendee["profile"]["name"];
	echo "<br>";
	echo $attendee["id"];
	echo "<br>";	
}

function testGetAllEvents() {
	$events = getAllEvents($PRI_TOKEN);
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
		getAllEvents($OAuthToken) //Pri_token get all of the events of a user<br>
		getAttendees($event_id) // get a list of all attendees' full name and email "fullname": "email" or 0 = {"name": <\fullname>, "email": <\email>}<br>
		getAttendeeInfo($attendee_id) // return entire attendee object<br>
	</body>

</html>