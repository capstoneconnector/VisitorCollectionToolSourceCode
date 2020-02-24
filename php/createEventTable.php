<?php
require_once "../php/getEvents.php";
$query = $_REQUEST['query'];
$events = searchEventsByName($query);
echo '<thead class="thead-dark">';
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Description</th>";
echo "<th>Date</th>";
echo "<th>Eventid</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach($events as $event){
    echo "<tr>";
    echo "<td><a href = 'event.php?eventid=".$event->getId()."'>".$event->getName()."</a></td>";
    echo "<td>".$event->getDescription()."</td>";
    echo "<td>".$event->getDate()."</td>";
    echo "<td>".$event->getId()."</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";