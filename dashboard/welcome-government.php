<?php
// Initialize session data
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
} 
// If the user is not government, don't give them access to this page
else if ($_SESSION['user_type'] != 'government') {
    // If the user is a learner, redirect
    if ($_SESSION['user_type'] == 'learner') {
        header("Location: ../dashboard/welcome.php");
        exit;
    }
    // If the user is a qsd, redirect
    else if ($_SESSION['user_type'] == 'qsd') {
        header("Location: ../dashboard/welcome-qsd.php");
        exit;
    }
    // If the user is an instructor, redirect
    else if ($_SESSION['user_type'] == 'instructor') {
        header("Location: ../dashboard/welcome-instructor.php");
        exit;
    } else {
        exit;
    }
}
?>
<!-- Super simple dashboard page for now, we can update this with anything we want -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Jordan Prime"; />
    <title>TLDR for Government</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div id = "content">
        <div id="dashboard">
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Students</h3>
                    <?php
                        if (isset($_SESSION['student'])) {
                            $studentname = $_SESSION['student']['username'];
                            $studentlicense = $_SESSION['student']['license'];
                            $studentaddress = $_SESSION['student']['address'];
                            $studentdob = $_SESSION['student']['dob'];
                            $studentage = date_diff(date_create(date("Y-m-d")), date_create($studentdob));
                            $studentage = $studentage->format('%y');
                            $studentnumber = $_SESSION['student']['contact_number'];
                            echo "<p>Name: {$studentname}</p>
                            <ul>
                                <li>Drivers License: {$studentlicense}</li>
                                <li>Address: {$studentaddress}</li>
                                <li>Date of Birth: {$studentdob} ( Age: {$studentage} )</li>
                                <li>Contact Number: {$studentnumber}</li>
                            </ul>
                            <a href='../search/search.php?usertype=student'>Change Student</a><br>
                            <a href='../students/cbt&a.php'>CBT&A Items</a><br>
                            <a href='#'>Logbook</a>
                            ";
                        } else {
                            $studentname = "No Student Selected";
                            echo "<p>Student Name: {$studentname}</p>";
                            echo '<a href="../search/search.php?usertype=student">Search Student</a><br>';
                            echo '<a href="../login/learner-login.php">Create New Student</a><br>';
                        }
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Instructors</h3>
                    <?php
                        if (isset($_SESSION['instructor'])) {
                            $instructorname = $_SESSION['instructor']['username'];
                            $instructorlicense = $_SESSION["instructor"]["license"];
                            $instructoraddress = $_SESSION["instructor"]["address"];
                            $instructordob = $_SESSION["instructor"]["dob"];
                            $instructorage = date_diff(date_create(date("Y-m-d")), date_create($instructordob));
                            $instructorage = $instructorage->format('%y');
                            $instructornumber = $_SESSION["instructor"]["contact_number"];
                            echo "<p>Name: {$instructorname}</p>
                            <ul>
                                <li>Drivers License: {$instructorlicense}</li>
                                <li>Address: {$instructoraddress}</li>
                                <li>Date of Birth: {$instructordob} ( Age: {$instructorage} )</li>
                                <li>Contact Number: {$instructornumber}</li>
                            </ul>
                            <a href='../search/search.php?usertype=instructor'>Change Instructor</a><br>
                            <a href='#'>View Report</a>
                            ";
                        } else {
                            $instructorname = "No Instructor Selected";
                            echo "<p>Instructor Name: {$instructorname}</p>";
                            echo '<a href="../search/search.php?usertype=instructor">Search Instructor</a><br>';
                            echo '<a href="../login/instructor-login.php">Create New Instructor</a><br>';
                        }
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Qualified Supervising Drivers</h3>
                    <?php
                        if (isset($_SESSION['qsd'])) {
                            $qsdname = $_SESSION['qsd']['username'];
                            $qsdlicense = $_SESSION["qsd"]["license"];
                            $qsdaddress = $_SESSION["qsd"]["address"];
                            $qsddob = $_SESSION["qsd"]["dob"];
                            $qsdage = date_diff(date_create(date("Y-m-d")), date_create($qsddob));
                            $qsdage = $qsdage->format('%y');
                            $qsdnumber = $_SESSION["qsd"]["contact_number"];
                            echo "<p>Name: {$qsdname}</p>
                            <ul>
                                <li>Drivers License: {$qsdlicense}</li>
                                <li>Address: {$qsdaddress}</li>
                                <li>Date of Birth: {$qsddob} ( Age: {$qsdage} )</li>
                                <li>Contact Number: {$qsdnumber}</li>
                            </ul>
                            <a href='../login/qsd-login.php'>Create New QSD</a><br>
                            <a href='../search/search.php?usertype=qsd'>Change Qualified Supervising Driver</a><br>
                            ";
                        } else {
                            $qsdname = "No QSD Selected";
                            echo "<p>Qualified Supervising Driver: {$qsdname}</p>";
                            echo '<a href="../search/search.php?usertype=qsd">Search Qualified Supervising Driver</a><br>';
                            echo '<a href="../login/qsd-login.php">Create New QSD</a><br>';
                        }
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Other</h3>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
