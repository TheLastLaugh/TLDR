<?php
// Initialize session data
session_start();

// add the database connection
require_once "../inc/dbconn.inc.php";

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
} 
// If the user is an instructor, don't give them access to this page
else if ($_SESSION['user_type'] == 'instructor') {
    header("Location: ../dashboard/welcome-instructor.php");
    exit;
}
// If the user is a qsd, don't give them access to this page
else if ($_SESSION['user_type'] == 'qsd') {
    header("Location: ../dashboard/welcome-qsd.php");
    exit;
}
// If the user is the government, don't give them access to this page
else if ($_SESSION['user_type'] == 'government') {
    header("Location: ../dashboard/welcome-government.php");
    exit;
}

?>

<!-- Super simple dashboard page for now, we can update this with anything we want -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alistair Macvicar"; />
    <title>TLDR For Learner Driver</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>

    <!-- These are all just hard-coded placeholder values. We can change these dynamically when we decide on the information to show -->
    <div id="content">
        <div id="dashboard">
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Hours Driven</h3>
                    <?php
                        $sql = "SELECT sum(duration) as total_minutes FROM logbooks WHERE learner_id = ? and confirmed = 1;";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ( mysqli_num_rows($result) >= 1 ) {
                            if ($row = $result -> fetch_assoc()) {
                                $total_hours = $row['total_minutes'] / 60;
                                echo "<p>{$total_hours} / 75 hours completed</p>";

                                $percentage = (int)( 100 / 75 ) * $total_hours;

                                if ($percentage > 100) {
                                    $percentage = 100;
                                }

                                echo "<div class='w3-light-grey'>
                                    <div class='w3-container w3-green w3-center' style='width:{$percentage}%'>{$percentage}%</div>
                                </div><br>";
                            }
                        }
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Night Time Driving</h3>
                    <?php
                        $sql = "SELECT sum(duration) as total_minutes FROM logbooks WHERE learner_id = ? AND confirmed = 1 AND time_of_day = 'Night';";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ( mysqli_num_rows($result) >= 1 ) {
                            if ($row = $result -> fetch_assoc()) {
                                $total_hours = $row['total_minutes'] / 60;
                                echo "<p>{$total_hours} / 15 hours completed</p>";

                                $percentage = (int)( 100 / 15 ) * $total_hours;

                                if ($percentage > 100) {
                                    $percentage = 100;
                                }

                                echo "<div class='w3-light-grey'>
                                    <div class='w3-container w3-green w3-center' style='width:{$percentage}%'>{$percentage}%</div>
                                </div><br>";
                            }
                        }
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Competency Based Training & Assessment Tasks</h3>
                    <?php

                        $total_tasks = 32;
                        $sql = "SELECT COUNT(*) as task_count FROM student_tasks WHERE student_id = ? AND student_signature = 1;";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if ( mysqli_num_rows($result) >= 1 ) {
                            if ($row = $result -> fetch_assoc()) {
                                $completed_tasks = $row['task_count'];
                                echo "<p>{$completed_tasks} / {$total_tasks} tasks completed</p>";
                                // echo "<br>";
                                $percentage = (int)( 100 / $total_tasks ) * $completed_tasks;
                                echo "<div class='w3-light-grey'>
                                    <div class='w3-container w3-green w3-center' style='width:{$percentage}%'>{$percentage}%</div>
                                </div><br>";
                            }
                        }
                    
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Day Time Driving</h3>
                    <?php
                        $sql = "SELECT sum(duration) as total_minutes FROM logbooks WHERE learner_id = ? AND confirmed = 1 AND time_of_day = 'Day';";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ( mysqli_num_rows($result) >= 1 ) {
                            if ($row = $result -> fetch_assoc()) {
                                $total_hours = $row['total_minutes'] / 60;
                                echo "<p>{$total_hours} hours</p>";
                            }
                        }
                    ?>
                </div>
                <!-- <div class="stat-card">
                    <h3>Total Lessons Completed</h3>
                    <p>15 lessons</p> 
                </div> -->
            </div>
        </div>
    </div>
</body>

</html>
