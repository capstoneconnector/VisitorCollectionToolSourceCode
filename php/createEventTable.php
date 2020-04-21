<?php
function createEventTable($events, $isEmail = false)
{
    $table = '<thead class="thead-dark">' .
    "<tr>" .
    "<th>Name</th>" .
     "<th>Description</th>".
     "<th>Date</th>".
     "<th>Eventid</th>";
    if($isEmail){
        $table .= "<th>Selected</th>";
    }
    $table .= "</tr>".
     "</thead>".
     "<tbody>";
    foreach ($events as $event) {
         $table .= "<tr>".
         "<td><a href = 'event.php?eventid=" . $event->getId() . "'>" . $event->getName() . "</a></td>".
         "<td>" . $event->getDescription() . "</td>".
         "<td>" . $event->getDate() . "</td>".
         "<td>" . $event->getId() . "</td>";
        if($isEmail){
            $table .= "<td><input name = 'selectedEvents' type = 'checkbox' checked = 'true' value = '" . $event->getId() . "'>";
        }

        $table .= "</tr>";
    }
    $table .= "</tbody>".
    "</table>".
     "</div>".
     "</div>";

    return $table;
}