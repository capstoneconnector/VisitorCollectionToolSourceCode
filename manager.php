<html>
	<head>
	</head>
	<body>
		<form method = "post">
			<input type = "submit" value = "Download Attendee Information">
			<input type = "hidden" name = "test" value = "test">
		</form>
	</body>
</html>

<?php
	if(!empty($_POST['test'])){
		if (file_exists("event.csv")) {
			$file = "event.csv";
     		header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($file).'"');
		    header('Expires: 0');
	        header('Cache-Control: must-revalidate');
	        header('Pragma: public');
	        header('Content-Length: ' . filesize($file));
	        flush();
		    readfile($file);
		}
	}
?>
