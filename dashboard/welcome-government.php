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
                        $studentname = "***Insert Student Name***";
                        echo "<p>Student Name: {$studentname}</p>";
                    ?>
                    <a href="../search/search.php">Search Student(s)</a><br>
                    <a href="#">CBT&A Items</a><br>
                    <a href="#">Logbook</a>
                </div>
                <div class="stat-card">
                    <h3>Instructors</h3>
                    <?php
                        $instructorname = "***Insert Instructor Name***";
                        echo "<p>Instructor Name: {$instructorname}</p>";
                    ?>
                    <a href="../search/search.php">Search Instructor(s)</a><br>
                    <a href="#">View Report</a>
                </div>
                <div class="stat-card">
                    <h3>Other</h3>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
