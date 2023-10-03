<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}
// If the user isn't a learner, don't give them access to this page
else if ($_SESSION['user_type'] != 'instructor') {
    header("Location: ../dashboard/welcome.php");
    exit;
}

// Uses the database connection and sidebar file
require_once "../inc/dbconn.inc.php"; 
include_once "../inc/sidebar.inc.php";

// Gets the user's id and name from the session
$learnerId = $_SESSION['userid'];
$learnerName = $_SESSION['username'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Darcy Foster" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" href="../styles/styles.css"/>
    <script src="calendar.js"></script>
</head>
<body>
    <div id = 'content'>
        <table>
            <tr>
                <th>Time</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
            </tr>
        </table>
    </div>
</body>
</html>