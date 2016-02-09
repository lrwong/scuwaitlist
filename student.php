
<html>
	<head>
		<meta charset="utf-8">
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
	<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
	</head>
	<body>
		<div class="content hidden">
			<div class="header" id="header">
				<h1>SCU Waitlist</h1>
				<p>Please fill out the form below to submit a request to be added to the waitlist.</p>
			</div>
			<div class="container" id="container">
				<form id="form" method="post" onSubmit="validateForm()" action="core/scripts/submitRequest.php" method="post" class="container">
					<div class="left">
						<p class="leftItem"><label for="selectDept">Select Department:</label>
							<select class="leftItem" id="dpmnt" name="dpmnt" required onchange="fillCourses()">
							</select>
						</p>
						<p class="leftItem">
							<label for="selectCourse">Select Course:</label>
							<select class="leftItem" id="course" name="course" required onchange="fillSection()">
								<option>Select Course</option>
							</select>
						</p>
						<p class="leftItem">
							<label for="sectionNumber">Section Number:</label>
							<select class="leftItem" id="section" name="section" class="section" required>
								<option>Select Section</option>
							</select>
						</p>
					</div>
					<div class="right">
						<div class="info">
							<div>
								<label for="fname">First Name:</label>
								<input type="text" id="fname" name="fname" maxlength="25" onchange="validateName()"  required>
							</div>
							<div>
								<label for="lname">Last Name:</label>
								<input type="text" id="lname" name="lname" maxlength="25" onchange="validateName()" required>
							</div>
							<div>
								<label for="id">Student ID:</label>
								<input type="text" id="id" name="id" required onchange="validateId()" placeholder="Ex. 0000012345">
							</div>
							<div>
								<label for="email">SCU email:</label>
								<input type="email" id="email" name="email" onchange="validateEmail()" required>
							</div>
						</div>
						<div class="below">
							<label for="reason">Please explain why you need this class</label><br>
							<textarea rows="3" id="reason" name="reason" required maxlength="250"></textarea>
							<div class="text-center">
								<button id="submit" class="btn btn-default" type="Submit">Submit</button>
								<div class="g-recaptcha" data-callback="enableBtn" data-sitekey="6LcqABATAAAAABikoeZYmOaiO7RvyG1nxT_HlVFA"></div>
							</div>
						</div>
	
					</div>
					
				</form>
			</div>
		</div>
	</body>
<html>
<script src="core/js/main.js">
		document.onload(document.getElementById('form').reset();
</script>