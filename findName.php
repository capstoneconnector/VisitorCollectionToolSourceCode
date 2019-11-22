<?php
function findName($fullName, $info)
    {
        $name = explode(" ", $fullName); //Split full name into first and last name
        $fname = $name [0];
        $lname =  $name [1];
        $matchL = array();
        for ($i = 0; $i < sizeof($info); $i++)
        {
            if ($info[$i][1] == $lname and $info[$i][3] == 0)
            {
                array_push($matchL, $info[$i]); //Match all that have the same last name
            }
        }
        $matchF = array();
        for ($i = 0; $i < sizeof($matchL); $i++)
        {
            if ($matchL[$i][0] == $fname)
            {
                array_push($matchF, $matchL[$i]); //Match all that have the same first name from the previous list
            }
        }
        return $matchF;
	}
?>