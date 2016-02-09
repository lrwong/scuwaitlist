<?php
// Returns all courses for a given department in json format. 
// Each name in the object is a course number for a department,
// while values are arrays that contain the section number for
// that course. For example: 
// Department = COEN
// 		{ 
// 			"12" : [00001, 00002],
// 			"19" : [90231, 21341, 41231]
// 		}
// COEN 12 has sections 00001 and 00002 offered.
// COEN 19 has sections 90231, 21341, and 41231 offered.

$department = $_POST['dpmnt'];

$file_path = "../storage/courses/engr.ser";
$fp = fopen($file_path, "r");
if(flock($fp, LOCK_SH)) {
	set_file_buffer($fp, 0);
	$course_list = unserialize(fread($fp, filesize($file_path)));
	flock($fp, LOCK_UN);
}
else
	error_log("unable to aquire read lock for courses");

//echo '<script>console.log('.json_encode($course_list[$department]).')</script>';
die(json_encode($course_list[$department]));
?>