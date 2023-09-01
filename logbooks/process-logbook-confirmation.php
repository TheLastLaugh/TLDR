<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../inc/dbconn.inc.php";

if (isset($_POST['logbook_id'])) {
    echo 'form submitted';
    $logbookId = $_POST['logbook_id'];
    
    $sql = "UPDATE logbooks SET confirmed = 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $logbookId);
    mysqli_stmt_execute($stmt);
}

header("Location: logbook-confirmation.php");
mysqli_close($conn);
exit();
?>