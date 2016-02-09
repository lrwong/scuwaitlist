<?php 
require_once('WaitlistEntry.php');

// A collection of waitlistEntries. Handles reading and writing to files
class Waitlist {
	private $department;
	private $section;
	private $course;
	private $entries;
	private $courseBucket;
	private $sectionBucket;
	private $filePath;
	
	public function __construct($department, $section = null, $course = null) {
		$this->department = $department;
		$this->section = $section;
		$this->course = $course;
		$this->entries = array();
		$this->filePath = "../storage/waitlists/". $department . ".csv";
		$data = "";
		if(file_exists($this->filePath)) {
			$fp = fopen($this->filePath, "r");
			// lock file for reading
			if(flock($fp, LOCK_SH)) {
				// write entire line before releasing lock
				set_file_buffer($fp, 0);
				$data = fread($fp, filesize($this->filePath));
				flock($fp, LOCK_UN);
			}
			else
				error_log("could not obtain lock for " . $this->department . " file.");
			fclose($fp);
			$this->genEntries($data);
		}
	}
	
	// adds waitlist entry to file
	public function add($csvRow) {
		$lock = fopen("../storage/waitlists/update.lock", "r");
		if(flock($lock, LOCK_SH)) {
			if(!file_exists($this->filePath))
				$entry = "Course,Section,First Name,Last Name,Email,Student ID,Reason" . $csvRow;
			else 
				$entry = $csvRow;
			$fp = fopen($this->filePath, 'a');
			chmod($this->filePath, 0600);
			// lock file for write
			if(flock($fp, LOCK_EX)) {
				// write entire line before releasing lock
				set_file_buffer($fp, 0);
				fwrite($fp, $entry);
				flock($fp, LOCK_UN);
			}
			else
				error_log("could not obtain lock for " . $this->department . " file.");
			fclose($fp);
		}
		else
			error_log("Could not add to waitlists");
		flock($lock, LOCK_UN);
		fclose($lock);
	}
	
	// displays waitlist as a HTML table
	public function display() {
		$count = 0;
		$entries = $this->entries;
		$display = array();
		for($i = 1; $i < count($entries); $i++) {
			if((isset($this->course) && $entries[$i]->getCourse() == $this->course) 
				&& (isset($this->section) && $entries[$i]->getSection() == $this->section)) {
					$display[] = $entries[$i];
				}
				
		}
		if(empty($entries) || empty($display)) {
			echo "No requests submitted yet";
			return;
		}
		?>
		<table>
			<thead>
				<tr>
					<th><?php echo $entries[0]->getCourse();?></th>
					<th><?php echo $entries[0]->getSection();?></th>
					<th><?php echo $entries[0]->getFirstName();?></th>
					<th><?php echo $entries[0]->getLastName();?></th>
					<th><?php echo $entries[0]->getEmail();?></th>
					<th><?php echo $entries[0]->getStudentId();?></th>
					<th><?php echo $entries[0]->getReason();?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($display as $d) {  ?>
						<tr>
							<td><?php echo $d->getCourse();?></td>
							<td><?php echo $d->getSection();?></td>
							<td><?php echo $d->getFirstName();?></td>
							<td><?php echo $d->getLastName();?></td>
							<td><?php echo $d->getEmail();?></td>
							<td><?php echo $d->getStudentId();?></td>
							<td><?php echo preg_replace("/;/", ",", $d->getReason());?></td>
						</tr>
					<?php } ?>
			</tbody>
		</table>
		<?php
	}
	
	// returns true if student id is aleady in the waitlist for a course and section, false otherwise
	public function inList($studentId, $department, $course, $section) {
		foreach($this->entries as $entry) {
			if($entry->getStudentId() == $studentId && $entry->getCourse() == $department . " " . $course && $entry->getSection() == $section)
				return true;
		}
		return false;
	}
	
	private function genEntries($csvData) {
		$rows = explode("\n", $csvData);
		foreach($rows as $r) {
			$fields = explode(",", $r);
			$params = array();
			$params['fName'] = $fields[WaitlistEntry::FNAME];
			$params['lName'] = $fields[WaitlistEntry::LNAME];
			$params['studentId'] = $fields[WaitlistEntry::STUID];
			$params['email'] = $fields[WaitlistEntry::EMAIL];
			$params['course'] = $fields[WaitlistEntry::COURSE];
			$params['section'] = $fields[WaitlistEntry::SECTION];
			$params['reason'] = $fields[WaitlistEntry::REASON];
			$params['department'] = $this->department;
			$this->entries[] = new WaitlistEntry($params);
		}
	}
}
?>
