<?php
// Intialise session
session_start();

// Add the database connection
require_once "../inc/dbconn.inc.php";

// if the form has been submitted, set the logbook entry to confirmed
if (isset($_POST['logbook_id'])) {
    echo 'form submitted';
    $logbookId = $_POST['logbook_id'];
    
    $sql = "UPDATE logbooks SET confirmed = 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $logbookId);
    mysqli_stmt_execute($stmt);
}

// Redirect back to the previous page
header("Location: logbook-confirmation.php");

// Close the connection and terminate the script
mysqli_close($conn);
exit();
?>