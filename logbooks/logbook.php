<?php
// Intialise session
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
} 
?>

<!-- A simple page to choose between viewing previous logbook entries, or adding/confirming a new one -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook</title>
    <link rel="stylesheet" href="../styles/logbook-styles.css"/>
</head>
<body>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>

    <div id="content">
        <div class="tab">
            <h1>Would you like to...</h1>
            <a href="logbook-submissions.php">View previous entries</a>

            <!-- If the user is a learner, they can confirm the entries -->
            <?php if($_SESSION['user_type'] == 'learner'): ?>
            <a href="logbook-confirmation.php">Confirm logbook entries</a>
            
            <!-- Otherwise, the user can create a new entry -->
            <?php else: ?>
            <a href="logbook-entry.php">Add a new entry</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>