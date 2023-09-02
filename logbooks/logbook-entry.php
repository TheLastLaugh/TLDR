<?php
// Intialise session
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
} 
// If the user is a learner, kick them out
else if ($_SESSION['user_type'] == 'learner') {
    header("Location: ../dashboard/welcome.php");
    exit();
}

// Include the database connection
require_once "../inc/dbconn.inc.php";

// Get the user id into a variable to make it easier to use later
$user_id = $_SESSION['userid'];

// query the correct user table to get the learner ids
if ($_SESSION['user_type'] == 'qsd') {
    // look up the qsd_learners table
    $result = mysqli_query($conn, "SELECT learner_id FROM qsd_learners WHERE qsd_id = $user_id");
} else if ($_SESSION['user_type'] == 'instructor') {
    // look up the qsd_learners table
    $result = mysqli_query($conn, "SELECT learner_id FROM instructor_learners WHERE instructor_id = $user_id");
}
?>

<!-- This page is only accessible to QSDs and instructors to enter a logbook for a learner -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alistair Macvicar" />
    <title>Logbook Entry</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div id="banner">Logbook Entry</div>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>

    <div class="content">
        <h1>Enter a drive for the learner</h1>
        <form action="process-logbook.php" method="POST">
            <ul>
                <li>
                    <label for="license">Learner's License</label>
                    <select name="license" required>
                        <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Get all the learners from the database associated with the qsd/instructor and display them in a drop-down menu
                                $learner_id = $row['learner_id'];

                                $sql = "SELECT license, username FROM users WHERE id = ?";
                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "i", $learner_id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                
                                // FORMT: <license> - <username>
                                echo '<option value="' . $row['license'] . '">' . $row['license'] . '-' .$row['username'] . '</option>';
                            }
                        ?>
                    </select>
                </li>
                
                <!-- Other static fields to fill in the drive details -->
                <li>
                    <label for="date">Date</label>
                    <input type="date" name="date" required>
                </li>
                <li>
                    <label for="start_time">Start Time</label>
                    <input type="time" name="start_time" required>
                </li>
                <li>
                    <label for="end_time">End Time</label>
                    <input type="time" name="end_time" required>
                </li>
                <li>
                    <label for="start_location">Starting Address (Suburb)</label>
                    <input type="text" name="start_location" required>
                </li>
                <li>
                    <label for="end_location">Ending Address (Suburb)</label>
                    <input type="text" name="end_location" required>
                </li>
                <li>
                    <label for="road_type">Road Type</label>
                    <select name="road_type" required>
                        <option value="Sealed">Sealed</option>
                        <option value="Unsealed">Unsealed</option>
                        <option value="Quit Street">Quiet Street</option>
                        <option value="Busy Road">Busy Road</option>
                        <option value="Multi-lanes Road">Multi-lanes Road</option>
                    </select>
                </li>
                <li>
                    <label for="weather">Weather</label>
                    <select name="weather">
                        <option value="Dry">Dry</option>
                        <option value="Wet">Wet</option>
                    </select>
                </li> 
                <li>
                    <label for="traffic">Traffic</label>
                    <select name="traffic">
                        <option value="Light">Light</option>
                        <option value="Medium">Medium</option>
                        <option value="Heavy">Heavy</option>
                    </select>
                </li>
                <li>
                    <input type="submit" value="Submit" class="submit-button">
                </li>
            </ul>
        </form>
    </div>
</body>
</html>