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
    <script src="./welcome.js"></script>
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
                                if ($total_hours < 75) {
                                    $hours_left = 75 - $total_hours;
                                    if ($hours_left == 1) {
                                        echo "<p>You have {$hours_left} hour left</p>";
                                    } else {
                                        echo "<p>You have {$hours_left} hours left</p>";
                                    }
                                }
                                $percentage = (int)(( 100 / 75 ) * $total_hours);
                                if ($percentage > 100) {
                                    $percentage = 100;
                                }
                                echo "<div class='w3-light-grey'>
                                    <div class='w3-container w3-green w3-center' style='width:{$percentage}%'>{$percentage}%</div>
                                </div><br>";
                            }
                        }

                        $sql = "SELECT count(*) as confirmation_needed FROM logbooks WHERE learner_id = ? AND confirmed = 0;";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ( mysqli_num_rows($result) >= 1 ) {
                            if ($row = $result -> fetch_assoc()) {
                                $confirmation_needed = $row['confirmation_needed'];
                                if ($confirmation_needed == 1) {
                                    echo "<p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle' viewBox='0 0 16 16'>
                                    <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                    <path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                                    </svg> There is {$confirmation_needed} logbook entry to confirm and sign</p>";
                                    echo "<a href='../logbooks/logbook-confirmation.php'>Confirm Logbook Entry</a><br>";
                                } else if ($confirmation_needed > 1) {
                                    echo "<p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle' viewBox='0 0 16 16'>
                                    <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                    <path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                                    </svg> There are {$confirmation_needed} logbook entries to confirm and sign</p>";
                                    echo "<a href='../logbooks/logbook-confirmation.php'>Confirm Logbook Entries</a><br>";
                                }
                            }
                        }
                        echo "<a href='../students/logbook.php'>View Logbook</a><br>";
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
                                if ($total_hours < 15) {
                                    $hours_left = 15 - $total_hours;
                                    if ($hours_left == 1) {
                                        echo "<p>You have {$hours_left} hour left</p>";
                                    } else {
                                        echo "<p>You have {$hours_left} hours left</p>";
                                    }
                                }

                                $percentage = (int)(( 100 / 15 ) * $total_hours);

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
                        $sql = "SELECT COUNT(*) as task_count FROM student_tasks WHERE student_id = ? AND completed = 1 AND student_signature = 1;";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if ( mysqli_num_rows($result) >= 1 ) {
                            if ($row = $result -> fetch_assoc()) {
                                $completed_tasks = $row['task_count'];
                                echo "<p>{$completed_tasks} / {$total_tasks} tasks completed</p>";
                                if ($completed_tasks < 32) {
                                    $tasks_left = 32 - $completed_tasks;
                                    if ($tasks_left == 1) {
                                        echo "<p>You have {$tasks_left} task left</p>";
                                    } else {
                                        echo "<p>You have {$tasks_left} tasks left</p>";
                                    }
                                } 
                                // echo "<br>";
                                $percentage = (int)(( 100 / $total_tasks ) * $completed_tasks);
                                echo "<div class='w3-light-grey'>
                                    <div class='w3-container w3-green w3-center' style='width:{$percentage}%'>{$percentage}%</div>
                                </div><br>";
                            }
                        }

                        $sql = "SELECT COUNT(*) as signature_required FROM student_tasks WHERE (student_id = ? AND completed = 1 AND (student_signature = 0 OR student_signature IS NULL));";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if ( mysqli_num_rows($result) >= 1 ) {
                            if ($row = $result -> fetch_assoc()) {
                                $signature_required = $row['signature_required'];
                                if ($signature_required == 1) {
                                    echo "<p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle' viewBox='0 0 16 16'>
                                    <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                    <path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                                    </svg> There is {$signature_required} task requiring your signature</p>";
                                } elseif ($signature_required > 1) {
                                    echo "<p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle' viewBox='0 0 16 16'>
                                    <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                    <path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                                    </svg> There are {$signature_required} tasks requiring your signature</p>";
                                }
                            }
                        }

                        $sql = "SELECT COUNT(*) as practise_required FROM student_tasks WHERE student_id = ? AND completed = 0 AND student_followup = 1;";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if ( mysqli_num_rows($result) >= 1 ) {
                            if ($row = $result -> fetch_assoc()) {
                                $followup_required = $row['practise_required'];
                                if ($followup_required == 1) {
                                    echo "<p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle' viewBox='0 0 16 16'>
                                    <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                    <path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                                    </svg> Your instructor has recommended  practise on {$followup_required} task</p>";
                                } elseif ($followup_required > 1) {
                                    echo "<p><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle' viewBox='0 0 16 16'>
                                    <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                    <path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                                    </svg> Your instructor has recommended  practise on {$followup_required} tasks</p>";
                                } 
                            }
                        }

                        echo "<a href='../students/cbt&a.php'>View CBT&A Tasks</a><br>";
                    
                    ?>
                </div>
                <div class="stat-card">
                    <h3>My Drives</h3>
                    <div id="googleMap" style="width:100%;height:400px;"></div>
                </div>
                <!-- <div class="stat-card">
                    <h3>Day Time Driving</h3>
                    <?php
                        // $sql = "SELECT sum(duration) as total_minutes FROM logbooks WHERE learner_id = ? AND confirmed = 1 AND time_of_day = 'Day';";
                        // $stmt = mysqli_prepare($conn, $sql);
                        // mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        // mysqli_stmt_execute($stmt);
                        // $result = mysqli_stmt_get_result($stmt);
                        // if ( mysqli_num_rows($result) >= 1 ) {
                        //     if ($row = $result -> fetch_assoc()) {
                        //         $total_hours = $row['total_minutes'] / 60;
                        //         echo "<p>{$total_hours} hours</p>";
                        //     }
                        // }
                    ?>
                </div> -->
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDiDOquqH11fiP_yFvh2PQFvUD76JWQh_Y&callback=myMap"></script>

</body>

</html>
