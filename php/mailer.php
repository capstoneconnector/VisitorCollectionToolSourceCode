<?php
require_once "../db/classes/DbClass.php";
require_once "../php/classes/Event.php";
require_once "../php/classes/Attendee.php";
require_once "../php/classes/Attendance.php";

function mailer() {
    /*
     * Set the settings for php.ini and sendmail.ini by watching this video (read description)
     * https://www.youtube.com/watch?v=9W644cyDyNM
     * if you are getting an error about unauthorized username and password, view this video
     * https://www.youtube.com/watch?v=L5uCc8Hab-I
     *
     * How to set up delayed mail sending using Cron and batch files
     * Windows Task scheduler:
     * https://www.youtube.com/watch?v=C4PdPqEOo6A
     * Max or linux cron:
     * https://www.youtube.com/watch?v=ZsxQenUjt5U
     */

    $result = true;

    $eventsYesterday = DbClass::readAllEventsYesterday();
    foreach ($eventsYesterday as $event) {
        $eventObj = new Event($event["Eventid"]);
        foreach ($eventObj->getAttendees() as $attendee) {
            $attendance = new Attendance($attendee->getId(), $eventObj->getId());
            if ($attendance->getIsAttended()) {
                $to      = $attendee->getEmail();
                $subject = "Thank You For Attending";
                $message = "Hey {$attendee->getFirstName()} {$attendee->getLastName()}, thank you for attending {$eventObj->getName()}. Take a look at the similar upcoming events at <a href='innovationconnector.com/coding-connector'>our website</a>.\n";
                $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
                var_dump($to, $message);

                if (mail($to, $subject, $message, $headers) == false) {
                    $result = false;
                }
            }
        }
    }
    return $result;
}

/**
 * Sends a customized thank you emails to each attendee of each event of $events
 *
 * @param $events
 * An itterable (array, set, dictionary...) of event objects
 * @return int
 * Number of emails succesfully sent. This does not tell if any emails failed to send.
 */
function sendThankYouByEvents($events) {
    $numberOfEmailsSent = 0;

    $subject = "Thank You For Attending";
    $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
    foreach ($events as $event) {
        foreach ($event->getAttendees() as $attendee) {
            $attendance = new Attendance($attendee->getId(), $event->getId());
            if ($attendance->getIsAttended()) {
                $to      = $attendee->getEmail();
                $message = "Hey {$attendee->getFirstName()} {$attendee->getLastName()}, thank you for attending {$event->getName()}. Take a look at the similar upcoming events at <a href='innovationconnector.com/coding-connector'>our website</a>.\n";

                if (mail($to, $subject, $message, $headers)) {
                    $numberOfEmailsSent += 1;
                }
            }
        }
    }
    return $numberOfEmailsSent;
}