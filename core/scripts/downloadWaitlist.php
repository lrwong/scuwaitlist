<?php
$department = $_GET['department'];
//$department = "COEN";
$file_path = "../storage/waitlists/".$department.".csv";

if(!file_exists($file_path)) {
	echo "Error downloading file";
	die();
}

// open temp file to copy contents of actual file for download
$temp = tmpfile();
$temp_file_path = stream_get_meta_data($temp)['uri'];

// open waitlist file and copy contents to temp file
$fp = fopen($file_path, "r");
if(flock($fp, LOCK_SH)) {	
	fwrite($temp, fread($fp, filesize($file_path)));
	flock($fp, LOCK_UN);
}
else {
	error_log("could not download file");
	echo 'Encountered error reading file. Please try again.';
	fclose($fp);
	fclose($temp);
	die();
}
fclose($fp);	
if(filesize($temp_file_path) != 0) {
	header('Content-Descripttion: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$department.'.csv"');	
	readfile($temp_file_path);
}
fclose($temp);
?>
