<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
} 

// Store the user id and username in variables to make them easier to use later
$user_id = $_SESSION['userid'];
$userName = $_SESSION['username'];

// Uses the database connection file
require_once "../inc/dbconn.inc.php";

// Query the correct user table to get the logbook submissions
if ($_SESSION['user_type'] == 'learner') {
    $sql = "SELECT id, qsd_name, date FROM logbooks WHERE learner_id = ? AND confirmed = 1;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else if ($_SESSION['user_type'] == 'qsd') {
    // QSDs can view te logbooks of all their learners (only when the logbook has been confirmed)
    $sql = "SELECT id, learner_id, date FROM logbooks WHERE qsd_id = ? AND confirmed = 1;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else if ($_SESSION['user_type'] == 'instructor') {
    // Instructors can view the logbooks of all their learners, regardless of confirmation status
    $sql = "SELECT id, learner_id, date FROM logbooks WHERE instructor_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
?>

<!-- A simple page with a drop-down menu that shows the user the logbook entries they are allowed to view -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook submissions</title>
    <link rel="stylesheet" href="../styles/logbook-styles.css"/>
</head>
<body>
    <div id="banner">Logbook submissions</div>
    <!-- include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>

    <?php
    // If there are no logbook submissions, display a message saying so
        if (mysqli_num_rows($result) == 0) {
            echo '<h1>
                    Hello, ' . $userName . '. You have no logbook submissions yet!.' .
                 '</h1>';
        } 
        // Otherwise display the logbooks in a drop-down menu
        else {
            echo '<h1>
                    Hello, ' . $userName . '. Select which logbook entry you wish to review.' .
                 '</h1>';
            
            // <!-- Step 1: Select logbook to review -->
            echo '<form action="view-logbook.php" method="POST">'; ?>
                <label for="unit">Select Logbook Entry You Wish To Review:</label>
                <select name="logbook">
                    <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            // If the user isn't a learner, get the name of the learner from the users table
                            // This way, the instructor and qsd can see the name of the learner, and the learner will see the name of the qsd/instructor
                            if ($_SESSION['user_type'] == 'instructor' || $_SESSION['user_type'] == 'qsd') {
                                $learner_id = $row['learner_id'];
                            
                                $sql = "SELECT username FROM users WHERE id = ?";
                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "i", $learner_id);
                                mysqli_stmt_execute($stmt);
                                $nameResult = mysqli_stmt_get_result($stmt);
                                $row = mysqli_fetch_assoc($nameResult);
                                $name = $row['username'];
                            } 
                            // Otherwise the name is just the qsd from the previous query
                            else {
                                $name = $row['qsd_name'];
                            }
                            
                            // Display the option in the drop-down menu
                            // FORMAT= <name> on <date>
                            echo '<option value="' . $row['id']  . '">' . 
                                    $name . ' on ' . $row['date'] .
                                 '</option>';
                        } 
                    ?>
                </select>
                <!-- Hidden input to hold the name value that we previously looked for -->
                <input type="hidden" name="name" value="<?php echo $name ?>">
                
                <input type="submit" value="Review logbook -->"></input>
            </form>
        <?php
        }
    ?>
</body>
</html>
