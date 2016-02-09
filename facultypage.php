<html>
        <head>
                <meta charset="utf-8">
                <link rel="stylesheet" type="text/css" href="style.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        </head>
        <body>
                <div class="content hidden">
                        <div class="header" id="header">
                                <h1>SCU Waitlist</h1>
                                <p>Please select department, course, and section to view a waitlist.</p>
                        </div>
                        <div class="container" id="container">
                                <div class="form container">
                                        <div class="left">
                                                <div id="quarter">
                                                </div>
                                                <p class="leftItem"><label for="selectDept">Select Department:</label>
                                                        <select class="leftItem" id="dpmnt" name="dpmnt" required onchange="fillCourses()">
                                                                <option>Select Option</option>
                                                                <option>Computer Engineering</option>
                                                        </select>
                                                </p>
                                                <p class="leftItem">
                                                        <label for="selectCourse">Select Course:</label>
                                                        <select class="leftItem" id="course" name="course" required onchange="fillSection()">
                                                                <option>Select Option</option>
                                                        </select>
                                                </p>
                                                <p class="leftItem">
                                                        <label for="sectionNumber">Section Number:</label>
                                                        <select class="leftItem" id="section" class="section" required>
                                                                <option>Select Option</option>
                                                        </select>
                                                </p>
                                                <p class="leftItem">
                                                        <button class="submitbutton">Enter</button>
                                                </p>
                                                <p class="leftItem">
                                                        <button class="downloadWaitlist">Download Waitlist</button>
                                                </p>
                                        </div>
                                        <div class="right">
                                                <div class="waitlist"></div>
        
                                        </div>
                                </div>
                        </div>
                </div>
        </body>
<html>
        
<script src="core/js/main.js"></script>
       
