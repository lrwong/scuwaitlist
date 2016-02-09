<?php
require_once("Waitlist.php");

// Holds all necessary inputs for a waitlist entry. Handles reading and writing to files.
class WaitlistEntry {
	// attributes associated with information a student submits 
	private $firstName;
	private $lastName;
	private $studentId;
	private $email;
	private $reason;
	private $department;
	private $course;
	private $section;	
	// constants that refer to the index of each field in a csv row
	// for example, accessing the course field from row in a csv file can be done in the following way:
	// explode("," $row)[COURSE];
	const COURSE = 0;
	const SECTION = 1;
	const FNAME = 2;
	const LNAME = 3;
	const EMAIL = 4;
	const STUID = 5;
	const REASON = 6;
	
	// creates a WaitlistEntry object. $params is an associative array of strings with the following indexes:
	// fName: first name of student
	// lName: last of student
	// email: email of student
	// studenId: ID number for student
	// reason: reason student wishes to be placed on waitlist
	// dept: four letter abbreviation of departments (computer engineering -> COEN, coen)
	// course: four letter abbreviation of department with two-three digit number for the course (COEN 12, COEN 20, COEN 174, etc.)
	// section: five digit number designating a section number for a course
	public function __construct($params) {
		$this->firstName = $params['fName'] == "" ? null : $this->sanitize($params['fName']);
		$this->lastName = $params['lName'] == "" ? null : $this->sanitize($params['lName']);
		$this->studentId = $params['studentId'] == "" ? null : $params['studentId'];
		$this->email = $params['email'] == "" ? null : $params['email'];
		$this->reason = $this->sanitize($params['reason']) == "" ? null : $this->sanitize($params['reason']);
		$this->course = $params['course'] == "Select Course" ? null : $params['course'];;
		$this->department = $params['department'] == "Select Department " ? null : $params['department'];
		$this->section = $params['section'] == "Select Section" ? null : $params['section'];
	}
	
	// getters
	public function getStudentId() {
		return $this->studentId;
	}
	
	public function getSection() {
		return $this->section;
	}
	
	public function getCourse() {
		return $this->course;
	}
	
	public function getFirstName() {
		return $this->firstName;
	}
	
	public function getLastName() {
		return $this->lastName;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getReason() {
		return $this->reason;
	}
	
	public function getDepartment() {
		return $this->department;
	}
	
	// Saves an entry to the appropiate file. Throws exception if student has already been added to waitlist
	public function save() {
		$waitlist = new Waitlist($this->department);
		if(!$this->verifyValues())
			throw new Exception("Error processing request. Please try again.");
		if($waitlist->inList($this->studentId, $this->department, $this->course, $this->section))
			throw new Exception("Student already added to waitlist");
		else 
			$waitlist->add($this->toCsv());
	}
	
	// Returns a valid row for a csv file with the following headers:
	// department course, section, firstName lastName, email, reason
	// ex: COEN 174, 12345, John, Doe, john@scu.edu, need for graduation
	public function toCsv() {
		return "\n" . $this->department . " " . $this->course . "," . 
			$this->section . "," . 
			$this->firstName . ",". 
			$this->lastName . "," .
			$this->email . "," .
			$this->studentId . "," .
			$this->reason;
	}
	
	private function sanitize($input) {
		// remove new line characters
		$output = preg_replace("/\r\n/", " ", $input);
		// replace commas with '\comma'
		$output = preg_replace("/,/", ";", $output);
		// remove any html tags
		$output = preg_replace("/<[^>]*>/", "", $output);
		return $output;
	}
	
	private function verifyValues() {
		$idPattern = "/\d{11}/";
		$emailPattern = "/.*@scu.edu/";
		if(!isset($this->course, $this->department, $this->section, $this->firstName, $this->lastName, $this->studentId, $this->email, $this->reason))
			return false;
		if(preg_match($idPattern, $this->studentId) == 0)
			return false;
		if(preg_match($emailPattern, $this->email) == 0)
			return false;
		return true;
	}
}
?>
