<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	include_once $root . "/php/readCSV.php";
	$csv = $root . "/resources/event.csv";
	$email = $_REQUEST["email"];
	if(!empty($email)){
		if(($file = fopen($csv, "r+")) !== FALSE){
			$info = readCSV($file);
			$newinfo = array();
			for($i = 0; $i < sizeof($info); $i++){
				if($info[$i][2] == $email){ //Match email received from AJAX request with DB info
					$newline = array($info[$i][0],$info[$i][1], $info[$i][2], 1); //When matched, prepare new line with checkin bit of 1
					array_push($newinfo, $newline);
				}
				else{
					array_push($newinfo, $info[$i]); //If email not matched, push line to be written to new temp csv unchanged
				}
			}

			if(($temp = fopen('temp.csv', 'w')) !== FALSE){  
				foreach ($newinfo as $rows){
	    			fputcsv($temp, $rows); //Open temp csv file for modified lines
				}    
				fclose($temp);
			}
			else{
				echo "Can't Open File";
			}
			fclose($file);
			rename('temp.csv', $csv); //Overwrite old csv and set proper permissions
			chmod($csv, 0666);
		}
	}
?>