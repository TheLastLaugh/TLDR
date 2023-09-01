<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons</title>
    <link rel="stylesheet" href="../styles/lesson-bookings-styles.css"/>
</head>
<body>
    <div id="banner">Lessons</div>
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div class="content">
        <a href="lesson-progress.php">Lesson Progress</a>
        <a href="lesson-bookings.php">Book a lesson</a>
    </div>
</body>
</html>