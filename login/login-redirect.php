<?php
// Initialise session
session_start();

// add the database connection
require_once "../inc/dbconn.inc.php";

// Check for errors
if (isset($_GET['error'])) {
    $error = $_GET['error'];

    switch($error) {
        case 'incorrect_email':
            $error_message = "This email is already in use. Please try again.";
            break;

        case 'invalid_licenses':
            if (isset($_GET['licenses'])) {
                $license = htmlspecialchars($_GET['licenses']);
                $error_message = "License: $license is not in our database";
            }
            break;
    }
}

?>

<!-- Error page if the user tries to sign up with invalid details -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alistair Macvicar">
    <title>Duplicate Email</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../scripts/loginScript.js" defer></script>
</head>
<body>
    <div class="container">
        <?php if ($error == 'incorrect_email') : ?>
        <h1>Duplicate Email Detected!</h1>
        <p>The email you've provided is already registered. Please use a different email or <a href="./index.php">login here</a>.</p>
        <?php elseif ($error == 'invalid_licenses') : ?>
        <h1>Learner Not Found!</h1>
        <p>The license(s): <?php echo $license ?> you've provided is not in our database. Please try again.</p>
        <?php endif; ?>

        <!-- Button that sends the user back to the previous page (from experimenting, this keeps the data they've put into the form so that they don't have to redo it) -->
        <button id="go_back">Go Back to Registration</button>
    </div>
</body>
</html>