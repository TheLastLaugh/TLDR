<?php
// Initialize session data
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
} 
// If the user is an instructor, don't give them access to this page
else if ($_SESSION['user_type'] == 'instructor') {
    header("Location: ../dashboard/welcome-instructor.php");
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
    <title>TLDR</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div id="banner">Welcome to TLDR</div>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>

    <!-- These are all just hard-coded placeholder values. We can change these dynamically when we decide on the information to show -->
    <div id="dashboard">
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Hours Driven</h3>
                <p>125 hours</p> 
            </div>
            <div class="stat-card">
                <h3>Total Lessons Completed</h3>
                <p>15 lessons</p> 
            </div>
            <div class="stat-card">
                <h3>Day Time Driving</h3>
                <p>80% completion</p> 
            </div>
            <div class="stat-card">
                <h3>Night Time Driving</h3>
                <p>50% completion</p> 
            </div>
        </div>
    </div>
</body>

</html>
