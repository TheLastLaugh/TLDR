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

else if ($_SESSION['user_type'] == 'qsd') {
    header("Location: ../dashboard/welcome-qsd.php");
    exit();
}

else if ($_SESSION['user_type'] == 'government') {
    header("Location: ../dashboard/welcome-government.php");
    exit();
}

// Include the database connection
require_once "../inc/dbconn.inc.php";

?>

<!-- This page is only accessible to QSDs and instructors to enter a logbook for a learner -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Jordan Prime" />
    <title>Logbook Entry</title>
    <!-- <link rel="stylesheet" href="../styles/styles.css"> -->
    <link rel="stylesheet" href="../styles/bill-entry.css"/>
    <script src="./issue-bill.js" defer></script>
</head>
<body>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>

    <div id="content">
        <div id="dashboard">
            <div id="form-container">

                <h1>Issue Bill</h1>

                <?php 
                    if ($_SESSION['user_type'] == 'instructor' && isset($_SESSION['student']['username'])) {
                        echo "<p>Student Name: {$_SESSION['student']['username']}</p>";
                        echo "<a href='../search/search.php?usertype=student'>Change Student</a><br><br>";
                    } 
                ?>

                <div class="row">
                    <div class="col-50">
                        <div id="taskAlert"></div>
                    </div>
                </div>  

                <form id="bill-entry">


                    <div class="row">
                        <div class="col-25">
                            <label for="due-date">Issue Date</label>
                        </div>
                        <div class="col-25">
                            <?php
                                $currentDate = date('Y-m-d');
                                echo "<input type='date' name='issue-date' id='issue-date' value='{$currentDate}' disabled>";
                            ?>
                        </div>
                    </div>

                    <div class="row" id="due-date-row">
                        <div class="col-25">
                            <label for="due-date">Due Date</label>
                        </div>
                        <div class="col-25">
                            <?php
                                $currentDate = date('Y-m-d');
                                echo "<input type='date' name='due-date' id='due-date' min='{$currentDate}' required>";
                            ?>
                            <!-- "<input type="date" name="due-date" id="due-date" min='{$currentDate}' required>"; -->
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-25">
                            <label for="duration">Duration</label>
                        </div>

                        <div class="col-25">
                            <input type="number" name="duration" id="duration" min="0" step="1" placeholder="Enter minutes here" required>
                        </div>

                    </div>

                    <div class="row" id="hourly_rate_option_row">

                        <div class="col-25">
                            <label for="rate-option">Hourly Rate Option</label>
                        </div>

                        <div class="col-25">
                            <?php

                                $sql = "SELECT price FROM instructors WHERE user_id = ?;";
                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if ( mysqli_num_rows($result) >= 1 ) {
                                    if ($row = $result -> fetch_assoc()) {
                                        echo "<input type='radio' id='system' name='rate-option' value='{$row['price']}' required>";
                                    }
                                } else {
                                    echo "<input type='radio' id='system' name='rate-option' value='0' required>";
                                }
                            ?>
                            <label for="system">System</label>
                            <input type="radio" id="manual" name="rate-option" value="">
                            <label for="manual">Manual</label><br><br>
                        </div>

                    </div>

                    <div class="row" id="hourly-rate-row">

                        <div class="col-25">
                            <label for="hourly-rate">Hourly Rate</label>
                        </div>
                        <div class="col-25">
                            <input type="number" name="hourly-rate" id="hourly-rate" min="0" step="0.01" placeholder="0.00" required>
                        </div>

                    </div>

                    <div class="row" id="amount-row">

                        <div class="col-25">
                            <label for="amount">Total ($)</label>
                        </div>
                        <div class="col-25">
                            <input type="number" name="amount" id="amount" min="0" step="0.01" placeholder="0.00" disabled>
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