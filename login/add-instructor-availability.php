<?php
// initialise session
session_start();

// check if user is logged in
require_once "../inc/dbconn.inc.php";

// Get the user's id from the session
$id = $_SESSION['userid'];

// Start from the day this gets built
$timestamp = time();

$sql = "INSERT INTO availability (instructor_id, start_time, end_time) VALUES ";

$insertValues = [];

for ($day = 0; $day < 7; $day++) { // 7 days
    for ($hour = 9; $hour < 17; $hour++) { // 9-5
        
        // Add the start and end times to the array
        $startHour = date('Y-m-d H:i:s', strtotime("+$day day +$hour hour", $timestamp));
        $endHour = date('Y-m-d H:i:s', strtotime("+$day day +" . ($hour + 1) . " hour", $timestamp));
        
        $insertValues[] = "($id, '{$startHour}', '{$endHour}')";
    }
}

// This little nutsack is phps way of concatenating strings ($sql = $sql + xyz)
$sql .= implode(',', $insertValues);


mysqli_query($conn, $sql);

// Redirect to the dashboard
header("Location: ../dashboard/welcome.php");

// Close the connection and terminate the script
mysqli_close($conn);
exit();
?>
