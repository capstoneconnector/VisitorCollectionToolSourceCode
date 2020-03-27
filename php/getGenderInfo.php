<?php

require_once "getEventInfo.php";

function getGenderDifferences($eventid){
    $maleCount = 0;
    $femaleCount = 0;
    $otherCount = 0;
    $gender = ["Male" => 0, "Female" => 0, "Other" => 0];
    $attendees = getEvent($eventid)->getAttendees();
    foreach($attendees as $attendee){
        if($attendee->getGender() == "Male"){
            $maleCount++;
        }
        else if ($attendee->getGender() == "Female"){
            $femaleCount++;
        }
        else{
            $otherCount++;
        }
    }
    $totalCount = $maleCount + $femaleCount + $otherCount;
    $gender["Male"] = $maleCount/$totalCount;
    $gender["Female"] = $femaleCount/$totalCount;
    $gender["Other"] = $otherCount/$totalCount;
    return $gender;
}
