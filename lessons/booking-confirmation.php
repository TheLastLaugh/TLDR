<?php
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

// Get the unit id from the form submission
$selectedUnit = isset($_POST['unit'])  ? $_POST['unit'] : null;
$result = mysqli_query($conn, "SELECT unit_name FROM lessons WHERE id = $selectedUnit");
$row = mysqli_fetch_assoc($result);
$unitName = $row['unit_name'];

// Get the instructor id from the form submission
$selectedInstructor = isset($_POST['instructor']) ? $_POST['instructor'] : null;
$result = mysqli_query($conn, "SELECT username FROM users WHERE id = $selectedInstructor");
$row = mysqli_fetch_assoc($result);
$instructorName = $row['username'];

// Get the availability id from the form submission
$selectedAvailability = isset($_POST['availability']) ? $_POST['availability'] : null;
$result = mysqli_query($conn, "SELECT start_time FROM availability WHERE id = $selectedAvailability");
$row = mysqli_fetch_assoc($result);
$bookingTime = $row['start_time'];

//This happens after the user clicks the confirm button after selecting all values. Relevant code for this is at the bottom of the page
if (isset($_POST['confirm'])) {
    // Insert the booking into the database
    $sql = "INSERT INTO bookings (learner_id, availability_id, booking_date) VALUES (?, ?, NOW())";
    $statement = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($statement, $sql);
    mysqli_stmt_bind_param($statement, "ii", $learnerId, $selectedAvailability); // 2 integers
    mysqli_stmt_execute($statement);
    
    // Sets the availability of the instructor to booked so it doesn't show up in the list of available times. This is unique for each Instructor.
    $sqlUpdate = "UPDATE availability SET is_booked = 1 WHERE id = ?";
    $statementUpdate = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($statementUpdate, $sqlUpdate);
    mysqli_stmt_bind_param($statementUpdate, "i", $selectedAvailability); // 1 integer
    mysqli_stmt_execute($statementUpdate);

    // Adds the learner as a student of the instructor so that they can enter the logbook easier later
    $sql = "INSERT INTO instructor_learners (id, learner_id) VALUES (?, ?)";
    $statementUpdate = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($statementUpdate, $sqlUpdate);
    mysqli_stmt_bind_param($statementUpdate, "ii", $selectedInstructor, $learnerId); // 2 integers
    mysqli_stmt_execute($statementUpdate);
}
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
                    ' . $unitName . ' lesson with ' . $instructorName . ' on ' . $bookingTime . '
                </h1>';
        ?>
    </div>
    
</body>
</html>