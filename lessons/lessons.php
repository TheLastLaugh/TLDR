<?php
// Intialise session
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}
// I haven't decided to kick anyone off this page based on user type yet, but this page will be different for each user
?>

<!-- A simple screen to choose between looking at previous lessons or booking a new one -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="Alistair Macvicar" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lessons</title>
        <link rel="stylesheet" href="../styles/lesson-bookings-styles.css"/>
    </head>
    <body>
        <!-- include the menu bar -->
        <?php include_once "../inc/sidebar.inc.php"; ?>
        <div id ="content">
            <div id="tab">
            <button class="lesson-progress"><a href="lesson-progress.php">Lesson Progress</a></button>
            <button class="lesson-bookings"><a href="lesson-bookings.php">Book a lesson</a></button>
                
            </div>
        </div>
    </body>
</html>