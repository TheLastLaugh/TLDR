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

// Define the insertion of logbooks so that I don't have to keep repeating the statements
function insertLogbook($learner_id, $qsd_id, $date, $start_time, $end_time, $duration, $start_location, $end_location, $road_type, $weather, $traffic, $qsd_name, $qsd_license, $time_of_day, $conn) {
    $sql = "INSERT INTO logbooks (learner_id, qsd_id, date, start_time, end_time, duration, start_location, end_location, road_type, weather, traffic, qsd_name, qsd_license, time_of_day) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iisssissssssss", $learner_id, $qsd_id, $date, $start_time, $end_time, $duration, $start_location, $end_location, $road_type, $weather, $traffic, $qsd_name, $qsd_license, $time_of_day);
    mysqli_stmt_execute($stmt);
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

// Set the timezone to Adelaide
$timezone = new DateTimeZone('Australia/Adelaide');

// Grab the date and times of the drive from the form
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

// echo $start_time;
// echo $end_time;

// Calculate the duration of the drive
$start = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $start_time, $timezone);
$end = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $end_time, $timezone);
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

// Calculate the sunset time for the given date using date_sun_info
$latitude = -34.9285;
$longitude = 138.6007;
$sunInfo = date_sun_info(strtotime($date), $latitude, $longitude);
$sunset = new DateTime('@' . $sunInfo['sunset']);
$sunset->setTimezone($timezone); 

if ($end <= $sunset) {
    echo 'day';
    $time_of_day = 'Day';
    insertLogbook($learner_id, $qsd_id, $date, $start_time, $end_time, $duration, $start_location, $end_location, $road_type, $weather, $traffic, $qsd_name, $qsd_license, $time_of_day, $conn);
} elseif ($start >= $sunset) {
    echo 'night';
    $time_of_day = 'Night';
    insertLogbook($learner_id, $qsd_id, $date, $start_time, $end_time, $duration, $start_location, $end_location, $road_type, $weather, $traffic, $qsd_name, $qsd_license, $time_of_day, $conn);
} else {
    echo 'split';
    $time_of_day_day = 'Day';
    $time_of_day_night = 'Night';
    $sunsetTimeStr = $sunset->format('H:i');
    $day_duration = date_diff($start, $sunset);
    $night_duration = date_diff($sunset, $end);

    // Convert the durations to minutes
    $day_duration_minutes = $day_duration->format('%a') * 24 * 60 + $day_duration->format('%h') * 60 + $day_duration->format('%i');
    $night_duration_minutes = $night_duration->format('%a') * 24 * 60 + $night_duration->format('%h') * 60 + $night_duration->format('%i');

    // Insert the logbook entry for day
    insertLogbook($learner_id, $qsd_id, $date, $start_time, $sunsetTimeStr, $day_duration_minutes, $start_location, $end_location, $road_type, $weather, $traffic, $qsd_name, $qsd_license, $time_of_day_day, $conn);
    // Insert the logbook entry for night
    insertLogbook($learner_id, $qsd_id, $date, $sunsetTimeStr, $end_time, $night_duration_minutes, $start_location, $end_location, $road_type, $weather, $traffic, $qsd_name, $qsd_license, $time_of_day_night, $conn);
}

// Redirect to the processed logbook page
header("Location: ../logbooks/logbook-processed.php");

//Close the connection and terminate the script.
mysqli_close($conn);
exit();
?>

