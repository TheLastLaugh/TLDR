<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../inc/dbconn.inc.php";

$id = $_SESSION['userid'];
// generate availability for an instructor in 1 hour blocks, 9-5, 7 days
// I don't really know how to implement this automatically yet, but I'm calling it when an instructor is created to add an availability block.

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


header("Location: ../dashboard/welcome.php");
mysqli_close($conn);
exit();
?>