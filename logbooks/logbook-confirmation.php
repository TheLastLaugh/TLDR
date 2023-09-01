<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
} else if ($_SESSION['user_type'] !== 'learner') {
    header("Location: ../dashboard/welcome.php");
    exit();
}

// Uses the database connection file
require_once "../inc/dbconn.inc.php"; 

$learnerId = $_SESSION['userid'];
$result = mysqli_query($conn, "SELECT username FROM users WHERE id = $learnerId");
$row = mysqli_fetch_assoc($result);
$learnerName = $row['username'];

// Get all the lessons from the booking table and display them in a drop-down menu
$sql = "SELECT id, date, qsd_name FROM logbooks WHERE learner_id = ? AND confirmed = 0;";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $learnerId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!-------------------------------------------------------------------------------------------------------------------
 * Simple form with drop-down menus can add anything you want in here to style the page
--------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Logbook</title>
    <link rel="stylesheet" href="../styles/logbook-styles.css"/>
</head>
<body>
    <div id="banner">Confirm Logbook</div>
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <?php
        if (mysqli_num_rows($result) == 0) {
            echo '<h1>
                    Hello, ' . $learnerName . '. You have no logbooks to confirm.' .
                 '</h1>';
        } else {
            echo '<h1>
                    Hello, ' . $learnerName . '. Select which logbook you would like to confirm.' .
                 '</h1>';

            // <!-- Step 1: Select logbook to confirm -->
            echo '<form action="logbook-confirm-details.php" method="POST">
                    <input type="hidden" name="learner_id" value="' . $learnerId . '">'; ?>
                <label for="unit">Select Logbook You Wish To Confirm:</label>
                <select name="logbook">
                    <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Display the option in the drop-down menu
                            // FORMAT= <qsd_name> on <date>
                            echo '<option value="' . $row['id']  . '">' . 
                                    $row['qsd_name'] . ' on ' . $row['date'] .
                                 '</option>';
                        } 
                    ?>
                </select>
                <input type="submit" value="View Details -->"></input>
            </form>
        <?php
        }
    ?>
</body>
</html>