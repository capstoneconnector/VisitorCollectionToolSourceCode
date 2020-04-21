<?php
require_once "../db/classes/DbClass.php";
require_once "classes/Event.php";
require_once "classes/Attendee.php";

/*
arg: $request is the url extension after the endpoint
arg: $options is extra arguments in the url. Must be a list of arguments e.g. ["arg=value", ...]
A full list of args may be found at //TODO find a list of args (url link)
*/
function wrapUrlRequestWithOptions(string $request, array $options) : string {
    require_once "../backend/parseConfig.php";
    $config         = parseConfig();
    $token_argument = "?token=" . $config["PRIVATE_TOKEN"];
    static $endpoint = "https://www.eventbriteapi.com/v3/";

    $args = "";
    foreach ($options as $arg) {
        $args .= "&" . $arg;
    }

    return $endpoint . $request . $token_argument . $args;
}

function wrapUrlRequest(string $request) : string {
    return wrapUrlRequestWithOptions($request, []);
}

function getJsonFromUrl(string $url) {
    return json_decode(file_get_contents($url), true);
}

function depaginate($page, $data_type) : array {
    $result = array();
    for ($i = 0; $i<$page["pagination"]["page_count"]; $i++) {
        $result += $page[$data_type];
    }
    return $result;
}

function pullEbEvents() : array {
    $contents = getJsonFromUrl(wrapUrlRequest("users/me/events"));
    return depaginate($contents, "events");
}

function pullEbAttendees(string $event_id) : array {
    $contents = getJsonFromUrl(wrapUrlRequest("events/" . $event_id . "/attendees/"));
    return depaginate($contents, "attendees");
}

function importEbEvents(string $oAuthToken) {
    $eventbriteEvents = pullEbEvents();
    foreach ($eventbriteEvents as $eventbriteEvent) {
        $date = date_create($eventbriteEvent["start"]["local"]);
        $date = date_format($date, "Y-m-d");

        $event = new Event();
        $event->create
        (
            $eventbriteEvent["name"]["text"],   // name
            $date,                              // date
            $eventbriteEvent["summary"],        // description
            $eventbriteEvent["id"]              // eventbrite Id
        );

        DbClass::insert($event);

        $eventbriteAttendees = pullEbAttendees($eventbriteEvent["id"]);
        foreach ($eventbriteAttendees as $eventbriteAttendee) {
            $eventbriteProfile = $eventbriteAttendee["profile"];
            $attendee          = new Attendee();
            $attendee->create
            (
                $eventbriteProfile["first_name"],
                $eventbriteProfile["last_name"],
                $eventbriteProfile["email"],
                "",
                "",
                $eventbriteAttendee["id"]
            );

            DbClass::insert($attendee);

            $event->addAttendee($attendee);

            DbClass::addRegistration($attendee->getId(), $event->getId(), false);
        }
    }
}

/*
pullEbEvents($OAuthToken) //Pri_token get all of the events of a user<br>
getAttendees($event_id) // get a list of all attendees' full name and email "fullname": "email" or 0 = {"name": <\fullname>, "email": <\email>}<br>
getAttendeeInfo($attendee_id) // return entire attendee object<br>

https://www.eventbriteapi.com/v3/users/me/events?token=OAUTH_TOKEN				//get all events' details
https://www.eventbriteapi.com/v3/events/EVENT_ID?token=OAUTH_TOKEN				//get one event's details
https://www.eventbriteapi.com/v3/events/EVENT_ID/attendees/?token=OAUTH_TOKEN	//get the attendee list for a specific event
 */



