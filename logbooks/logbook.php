<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
} else if ($_SESSION['user_type'] == 'qsd' || $_SESSION['user_type'] == 'instructor') {
    header("Location: ../logbooks/logbook-entry.php");
    exit();
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbooks</title>
    <link rel="stylesheet" href="../styles/logbook-styles.css"/>
</head>
<body>
    <div id="banner">Lessons</div>
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div class="content">
        <h1>Would you like to...</h1>
        <a href="logbook-submissions.php">View previous entries</a>
        <?php if($_SESSION['user_type'] == 'learner'): ?>
        <a href="logbook-confirmation.php">Confirm logbook entries</a>
        <?php else: ?>
        <a href="logbook-entry.php">Add a new entry</a>
        <?php endif; ?>
    </div>
</body>
</html>