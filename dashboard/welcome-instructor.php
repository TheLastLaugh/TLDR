<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
} else if ($_SESSION['user_type'] == 'learner') {
    header("Location: ../dashboard/welcome.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLDR</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div id="banner">Welcome to TLDR</div>
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div id="dashboard">
        <div class="stats-container">
            <div class="stat-card">
                <h3>Some stuff relating to instructors</h3>
                <p>bookings or something</p> 
            </div>
        </div>
    </div>
</body>

</html>
