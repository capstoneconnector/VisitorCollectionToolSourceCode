<?php
function readCSV($file){
		$info = array();
		while (($data = fgetcsv($file, 1000, ",")) !== FALSE){
			array_push($info, $data); //Put each row of the csv into an array
		}
		return $info;
	}
?>