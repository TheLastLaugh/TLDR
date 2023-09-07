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
                        if (isset($_SESSION['student-username'])) {
                            $studentname = $_SESSION['student-username'];
                            echo "<p>Student Name: {$studentname}</p>";
                            echo '<a href="../search/search.php">Change Student</a><br>';
                            echo '<a href="#">CBT&A Items</a><br>';
                            echo '<a href="#">Logbook</a>';
                        } else {
                            $studentname = "No Student Selected";
                            echo "<p>Student Name: {$studentname}</p>";
                            echo '<a href="../search/search.php">Search Student</a><br>';
                        }
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Instructors</h3>
                    <?php
                        if (isset($_SESSION['instructor-username'])) {
                            $instructorname = $_SESSION['instructor-username'];
                            echo "<p>Instructor Name: {$instructorname}</p>";
                            echo '<a href="../search/search.php">Change Instructor</a><br>';
                            echo '<a href="#">View Report</a>';
                        } else {
                            $instructorname = "No Instructor Selected";
                            echo "<p>Instructor Name: {$instructorname}</p>";
                            echo '<a href="../search/search.php">Search Instructor</a><br>';
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
