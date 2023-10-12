<?php 
    // Initialize the session
    session_start();

    // Check if the user is logged in, if not, send them back to the login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: ../login/index.php");
        exit;
    }
    // If the user isn't a learner, don't give them access to this page
    else if ($_SESSION['user_type'] != 'learner') {
        header("Location: ../dashboard/welcome.php");
        exit;
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Darcy Foster">
    <title>Lessons</title>
</head>
<body>
    <?php 
    require "../inc/dbconn.inc.php";
    include_once "../inc/sidebar.inc.php";
    ?>
</body>
</html>