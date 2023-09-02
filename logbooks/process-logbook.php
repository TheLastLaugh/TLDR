<?php
// Initialise session
session_start();

// Add the database connection
require_once "../inc/dbconn.inc.php";

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
}

// Get the id of the learner from the entered license number 
$learner_license = $_POST['license'];
$sql = "SELECT id FROM users WHERE license = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $learner_license);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$learner_id = $row['id'];

// Grab the date and times of the drive from the form
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

// Calculate the duration of the drive
$start = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $start_time);
$end = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $end_time);
$interval = date_diff($start, $end);

// Convert the duration to minutes
$duration = $interval->format('%a') * 24 * 60 + $interval->format('%h') * 60 + $interval->format('%i');

// Get the rest of the information from the form
$start_location = $_POST['start_location'];
$end_location = $_POST['end_location'];
$road_type = $_POST['road_type'];
$weather = $_POST['weather'];
$traffic = $_POST['traffic'];
$qsd_id = $_SESSION['userid'];

// Get the name and license of the QSD. These items are not included in the form since they're already known to us from the session
// USER EXPERIENCE BABYYYYYYYYYY
$sql = "SELECT username, license FROM users WHERE id = ?;";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $qsd_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$qsd_name = $row['username'];
$qsd_license = $row['license'];

// Insert the logbook entry into the database
// All of the attributes are straight from the learner's handbook, that's why there are sooooo many
$sql = "INSERT INTO logbooks (learner_id, qsd_id, date, start_time, end_time, duration, start_location, end_location, road_type, weather, traffic, qsd_name, qsd_license) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iisssisssssss", $learner_id, $qsd_id, $date, $start_time, $end_time, $duration, $start_location, $end_location, $road_type, $weather, $traffic, $qsd_name, $qsd_license);
mysqli_stmt_execute($stmt);

// Redirect to the processed logbook page
header("Location: ../logbooks/logbook-processed.php");

//Close the connection and terminate the script.
mysqli_close($conn);
exit();
?>