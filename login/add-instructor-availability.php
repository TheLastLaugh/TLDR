<?php
// initialise session
session_start();

// check if user is logged in
require_once "../inc/dbconn.inc.php";

// Get the user's id from the session
$id = $_SESSION['userid'];

// generate availability for an instructor in 1 hour blocks, 9-5, 1 day
// I don't really know how to implement this automatically yet, but I'm calling it when an instructor is created to add an availability block.
// it's locked to a single day but I think I can figure out a loop to change the date and add a new block for each day
$sql = "INSERT INTO availability (instructor_id, start_time, end_time) VALUES
($id, '2023-08-24 09:00:00', '2023-08-24 10:00:00'),
($id, '2023-08-24 10:00:00', '2023-08-24 11:00:00'),
($id, '2023-08-24 11:00:00', '2023-08-24 12:00:00'),
($id, '2023-08-24 12:00:00', '2023-08-24 13:00:00'),
($id, '2023-08-24 13:00:00', '2023-08-24 14:00:00'),
($id, '2023-08-24 14:00:00', '2023-08-24 15:00:00'),
($id, '2023-08-24 15:00:00', '2023-08-24 16:00:00'),
($id, '2023-08-24 16:00:00', '2023-08-24 17:00:00');";

mysqli_query($conn, $sql);

// Redirect to the dashboard
header("Location: ../dashboard/welcome.php");

// Close the connection and terminate the script
mysqli_close($conn);
exit();
?>