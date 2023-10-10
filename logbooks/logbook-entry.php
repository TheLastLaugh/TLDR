<?php
// Intialise session
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
} 
// If the user is a learner, kick them out
else if ($_SESSION['user_type'] == 'learner') {
    header("Location: ../dashboard/welcome.php");
    exit();
}

// Include the database connection
require_once "../inc/dbconn.inc.php";

// Get the user id into a variable to make it easier to use later
$user_id = $_SESSION['userid'];

// query the correct user table to get the learner ids
if ($_SESSION['user_type'] == 'qsd') {
    // look up the qsd_learners table
    $result = mysqli_query($conn, "SELECT learner_id FROM qsd_learners WHERE qsd_id = $user_id");
} else if ($_SESSION['user_type'] == 'instructor') {
    // look up the qsd_learners table
    $result = mysqli_query($conn, "SELECT learner_id FROM instructor_learners WHERE instructor_id = $user_id");
}
?>

<!-- This page is only accessible to QSDs and instructors to enter a logbook for a learner -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="author" content="Jordan Prime" />
    <title>Logbook Entry</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/logbook-entry.css"/>
    <script src="./suburb-validation.js" defer></script>
</head>
<body>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>

    <div id="content">
        <div id="dashboard">
            <div id="form-container">

                <h1>Create Log Book Entry</h1>

                <?php 
                    if (($_SESSION['user_type'] == 'instructor' || $_SESSION['user_type'] == 'government' || $_SESSION['user_type'] == 'qsd') && isset($_SESSION['student']['username'])) {
                        echo "<p>Student Name: {$_SESSION['student']['username']}</p>";
                        echo "<a href='../search/search.php?usertype=student'>Change Student</a><br><br>";
                    } 
                ?>

                <div class="row">
                    <div class="col-50">
                        <div id="taskAlert"></div>
                    </div>
                </div>  

                <form id="logbook-entry">
                    <!-- <div class="row">
                        <div class="col-25">
                            <label for="license">Learner's License</label>
                        </div>
                        <div class="col-25">
                        <?php
                            // echo "<input type='text' name='license' value='{$_SESSION['student']['license']}' required readonly disabled>";
                        ?>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-25">
                            <label for="date">Date</label>
                        </div>
                        <div class="col-25">
                            <input type="date" name="date" id="date" required>
                        </div>
                    </div>

                    <div class="row" id="start_time_row">

                        <div class="col-25">
                            <label for="start_time">Start Time</label>
                        </div>
                        <div class="col-25">
                            <input type="time" name="start_time" id="start_time" required>
                        </div>

                    </div>
                    <div class="row" id="end_time_row">

                        <div class="col-25">
                            <label for="end_time">End Time</label>
                        </div>
                        <div class="col-25">
                            <input type="time" name="end_time" id="end_time" required>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="start_location">Starting Suburb</label>
                        </div>
                        <div class="col-25">
                            <input type="text" name="start_location" id="start-suburb" list="suburbsList" placeholder="Type Suburb..." spellcheck="false" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="end_location">Ending Suburb</label>
                        </div>
                        <div class="col-25">
                            <input type="text" name="end_location" id="end-suburb" list="suburbsList" placeholder="Type Suburb..." spellcheck="false" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="road_type">Road Type</label>
                        </div> 
                        <div class="col-25">
                            <select name="road_type" required>
                                <option value="" selected disabled>Please Select</option>
                                <option value="Sealed">Sealed</option>
                                <option value="Unsealed">Unsealed</option>
                                <option value="Quiet Street">Quiet Street</option>
                                <option value="Busy Road">Busy Road</option>
                                <option value="Multi-lanes Road">Multi-lanes Road</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="weather">Weather</label>
                        </div>
                        <div class="col-25">
                            <select name="weather" required>
                                <option value="" selected disabled>Please Select</option>
                                <option value="Dry">Dry</option>
                                <option value="Wet">Wet</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="traffic">Traffic</label>
                        </div>
                        <div class="col-25">
                            <select name="traffic" required>
                                <option value="" selected disabled>Please Select</option>
                                <option value="Light">Light</option>
                                <option value="Medium">Medium</option>
                                <option value="Heavy">Heavy</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <input type="reset" value="Clear">
                        </div>
                        <div class="col-25">
                            <input type="submit" value="Submit">
                        </div>
                    </div>

                    <datalist id="suburbsList"></datalist>
                </form>
            </div>
        </div>
    </div>

</body>
</html>