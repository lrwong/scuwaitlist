<?php
$department = $_POST['department'];
if(file_exists("../storage/waitlists/".$department.".csv"))
	die("true");
die("false");
?>
