<?php
// error check
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Initialize the session
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}

// Uses the database connection file
require_once "../inc/dbconn.inc.php"; 

// Get the id of the learner
$learnerId = $_SESSION['userid'];
$result = mysqli_query($conn, "SELECT username FROM users WHERE id = $learnerId");
$row = mysqli_fetch_assoc($result);
$learnerName = $row['username'];

// Get the instructor id from the form submission
$selectedInstructor = isset($_POST['instructorID']) ? $_POST['instructorID'] : null;
$instructorName = isset($_POST['instructorName']) ? $_POST['instructorName'] : null;

// Get Date and time
$date = isset($_POST['date']) ? $_POST['date'] : null;
$time = isset($_POST['time']) ? $_POST['time'] : null;

// Get Pickup Location
$pickupLocation = isset($_POST['pickup_location']) ? $_POST['pickup_location'] : null;


//This happens after the user clicks the confirm button after selecting all values. Relevant code for this is at the bottom of the page
// Insert the booking into the database
$sql = "INSERT INTO bookings (instructor_id, learner_id, booking_date, booking_time, pickup_location) VALUES (?, ?, ?, ?, ?)";
$statement = mysqli_stmt_init($conn);
mysqli_stmt_prepare($statement, $sql);
mysqli_stmt_bind_param($statement, "iisss", $selectedInstructor, $learnerId, $date, $time, $pickupLocation);
mysqli_stmt_execute($statement);

// Adds the learner as a student of the instructor so that they can enter the logbook easier later
$sql = "INSERT INTO instructor_learners (instructor_id, learner_id) VALUES (?, ?)";
$statementUpdate = mysqli_stmt_init($conn);
mysqli_stmt_prepare($statementUpdate, $sql);
mysqli_stmt_bind_param($statementUpdate, "ii", $selectedInstructor, $learnerId); // 2 integers
mysqli_stmt_execute($statementUpdate);
?>

<!-- Simple confirmation page to let the user know that the booking bas gone through -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book A Lesson</title>
    <link rel="stylesheet" href="../styles/lesson-bookings-styles.css"/>
    <script src="../scripts/bookingScript.js"></script>
</head>
<body>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div id = "content">
        <?php
            echo '<h1>
                    Lesson booked successfully! <br>
                    Lesson with ' . $instructorName . ' on ' . $date . ' at ' . $time . '
                </h1>';
        ?>
    </div>
    
</body>
</html>