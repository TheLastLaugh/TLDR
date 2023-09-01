<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../inc/dbconn.inc.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
} else if ($_SESSION['user_type'] == 'learner') {
    header("Location: ../logbooks/logbook-entry.php");
    exit();
}

$learner_license = $_POST['license'];
$sql = "SELECT id FROM users WHERE license = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $learner_license);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$learner_id = $row['id'];

$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

$start = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $start_time);
$end = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $end_time);

$interval = date_diff($start, $end);

$duration = $interval->format('%a') * 24 * 60 + $interval->format('%h') * 60 + $interval->format('%i');
$start_location = $_POST['start_location'];
$end_location = $_POST['end_location'];
$road_type = $_POST['road_type'];
$weather = $_POST['weather'];
$traffic = $_POST['traffic'];
$qsd_id = $_SESSION['userid'];

$sql = "SELECT username, license FROM users WHERE id = ?;";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $qsd_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$qsd_name = $row['username'];
$qsd_license = $row['license'];

$sql = "INSERT INTO logbooks (learner_id, qsd_id, date, start_time, end_time, duration, start_location, end_location, road_type, weather, traffic, qsd_name, qsd_license) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iisssisssssss", $learner_id, $qsd_id, $date, $start_time, $end_time, $duration, $start_location, $end_location, $road_type, $weather, $traffic, $qsd_name, $qsd_license);
mysqli_stmt_execute($stmt);

header("Location: ../logbooks/logbook-processed.php");
mysqli_close($conn);
exit();
?>