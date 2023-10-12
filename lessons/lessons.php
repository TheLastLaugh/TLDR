<?php
// Intialise session
session_start();

function getUpcomingLessons($user_id, $conn) {
    $result = mysqli_query($conn, "SELECT b.* FROM bookings as b WHERE learner_id = $user_id ORDER BY booking_date, booking_time ASC");
    while($row = mysqli_fetch_assoc($result)){
        echo("<li>On the ". $row["booking_date"]." at " . date('g a',strtotime($row["booking_time"])) . ", you have a booking with " ."</li>");
    }
}

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}
require "../inc/dbconn.inc.php"
// I haven't decided to kick anyone off this page based on user type yet, but wthis page will be different for each user
?>

<!-- A simple screen to choose between looking at previous lessons or booking a new one -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="Alistair Macvicar + Darcy Foster" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lessons</title>
        <link rel="stylesheet" href="../styles/lesson-bookings-styles.css"/>
    </head>
    <body>
        <!-- include the menu bar -->
        <?php include_once "../inc/sidebar.inc.php"; ?>
        <div id ="content">
            <div class = "boxed">
                <h1>Book Your Lesson! WOWIES</h1>
                <ul id = "upcoming-lessons">
                    <?php getUpcomingLessons($_SESSION["userid"], $conn); ?>
                </ul>
                <button class="lesson-buttons"><a href="choose-time.php">Book a lesson</a></button>
            </div>
        </div>
    </body>
</html>