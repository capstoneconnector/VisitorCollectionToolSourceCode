<?php
$PRI_TOKEN = "COKR3D7YQAPZM2GWLOTL";

/*
arg: $requeset is the url extention after the endpoint
arg: $options is extra aruments in the url. Must be a list of arguments e.g. ["arg=value", ...]
*/
function wrapUrlRequestWithOptions($request, $options) {
	require_once "../php/parseConfig.php";
	$config = parseConfig();
	$token_argument = "?token=" . $config["PRIVATE_TOKEN"];
	static $endpoint = "https://www.eventbriteapi.com/v3/";

	$args = "";
	foreach ($options as $arg) {
		$args += "&".$arg;
	}

	return $endpoint.$request.$token_argument.$args;
}

function wrapUrlRequest($request) {
	return wrapUrlRequestWithOptions($request, []);
}

function getJsonFromUrl($url) {
	return json_decode(file_get_contents($url), true);
}

function depaginate($page, $data_type) {
	$result = array();
	for ($i=0; i<$page["pagination"]["page_count"]; i++) {
		$result += $page[$data_type];
	}
	return $result;
}

function pullEbEvents($OAuthToken) {
	$contents = getJsonFromUrl(wrapUrlRequest("users/me/events"));
	return depaginate($contents, "events");	 
}

function pullEbAttendees($event_id) {
	$contents = getJsonFromUrl(wrapUrlRequest("events/".$event_id."/attendees/"));
	return depaginate($contents, "attendees");
}

function importEbEvents($oAuthToken) {
	require_once "../db/dbInterface.php";

	$events = pullEbEvents($oAuthToken);
	foreach ($events as $event) {
		addEvent($event["name"], $event["start"]["local"]);	// TODO date needs formatting

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