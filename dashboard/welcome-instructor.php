<?php
// Initialize session data
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
} 
// If the user is a learner, don't give them access to this page
else if ($_SESSION['user_type'] == 'learner') {
    header("Location: ../dashboard/welcome.php");
    exit;
}
// If the user is a qsd, don't give them access to this page
else if ($_SESSION['user_type'] == 'qsd') {
    header("Location: ../dashboard/welcome-qsd.php");
    exit;
}
?>
<!-- Super simple dashboard page for now, we can update this with anything we want -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alistair Macvicar"; />
    <meta name="author" content="Jordan Prime"; />
    <title>TLDR for Instructor</title>
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
                            $studentnumber = $_SESSION['student']['contact_number'];
                            $studentaddress = $_SESSION['student']['address'];
                            $studentdob = $_SESSION['student']['dob'];
                            $studentage = date_diff(date_create(date("Y-m-d")), date_create($studentdob));
                            $studentage = $studentage->format('%y');
                            echo '<a href="../search/search.php?usertype=student">Change Student</a><br>';
                            echo '<a href="../login/learner-login.php">Create New Student</a>';
                            echo "<p>Student Name: {$studentname}</p>
                            <ul>
                                <li>Address: {$studentaddress}</li>
                                <li>Age: {$studentage}</li>
                                <li>Contact Number: {$studentnumber}</li>
                            </ul>";
                            echo '<a href="../students/cbt&a.php">CBT&A Items</a><br>';
                            echo "<a href='../students/logbook.php'>View Logbook</a><br>";
                            echo '<a href="../logbooks/logbook-entry.php">Add a new logbook entry</a><br>';
                            echo '<a href="#">Issue Bill</a>';
                        } else {
                            $studentname = "No Student Selected";
                            echo "<p>Student Name: {$studentname}</p>";
                            echo '<a href="../search/search.php?usertype=student">Search Student</a><br>';
                            echo '<a href="../login/learner-login.php">Create New Student</a><br>';
                        }
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Qualified Supervising Drivers</h3>
                    <a href="../login/qsd-login.php">Create New QSD</a><br>
                </div>
                <div class="stat-card">
                    <h3>Billing</h3>
                    <a href="#">View Issued Bills</a><br>
                </div>
                <div class="stat-card">
                    <h3>Some stuff relating to instructors</h3>
                    <p>bookings or something</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
