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
// If the user is not government, don't give them access to this page
else if ($_SESSION['user_type'] != 'government') {
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
    <meta name="author" content="Jordan Prime"; />
    <title>TLDR</title>
    <link rel="stylesheet" href="../styles/instructor-report.css">
</head>
<body>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>

    <!-- These are all just hard-coded placeholder values. We can change these dynamically when we decide on the information to show -->
    <div id="content">
        <div id="dashboard">
                <h3>Instructor Report</h3>
                <?php
                    echo "<p>Instructor Name: {$_SESSION['instructor']['username']}</p>";

                    $sql = "SELECT SUM((billed_minutes/60)*hourly_rate) as total_revenue FROM bills WHERE instructor_id = ?;";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $_SESSION["instructor"]["id"]);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ( mysqli_num_rows($result) >= 1 ) {
                        if ($row = $result -> fetch_assoc()) {
                            $revenue = number_format($row['total_revenue'], 2);
                            echo "<p>Total income generated: $" . "{$revenue}</p>";
                        }
                    }

                    $sql = "SELECT SUM(billed_minutes) as total_time FROM bills WHERE instructor_id = ?;";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $_SESSION["instructor"]["id"]);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ( mysqli_num_rows($result) >= 1 ) {
                        if ($row = $result -> fetch_assoc()) {
                            if ($row['total_time'] == NULL) {
                                echo "<p>Total time spent with students: 0 minutes</p>";
                            } else {
                                echo "<p>Total time spent with students: {$row['total_time']} minutes</p>";
                            }
                        }
                    }

                ?>
                <br>
                <p>Below is a list of the instructors students</p>
                <table style="width:100%">
                    <tr>
                        <th style="width:25%">Student Name</th>
                        <th style="width:25%">Time (Minutes)</th>
                        <th style="width:25%">Transactions</th>
                        <th style="width:25%">CBT&A Items Completed</th>
                    </tr>
                    <?php

                        // Return a unique lit of student ids that the instructor has dealings with
                        $sql = "SELECT DISTINCT bills.learner_id as student_id, users.username as student_name
                        FROM bills
                        LEFT JOIN users
                        ON bills.learner_id = users.id
                        WHERE instructor_id = ?
                        UNION
                        SELECT DISTINCT student_tasks.student_id, users.username
                        FROM student_tasks
                        LEFT JOIN users
                        ON student_tasks.student_id = users.id
                        WHERE completed_instructor_id = ?;";

                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "ii", $_SESSION["instructor"]["id"], $_SESSION["instructor"]["id"]);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if ( mysqli_num_rows($result) >= 1 ) {
                            while ($row = $result -> fetch_assoc()) {
                                $student_id = $row['student_id'];

                                echo "<tr>";
                                echo "<td>{$row['student_name']}</td>";

                                $sql = "SELECT SUM(billed_minutes) as student_total_time, count(id) as student_transaction_count
                                FROM bills
                                WHERE instructor_id = ? AND learner_id = ?";
                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "ii", $_SESSION["instructor"]["id"], $row['student_id']);
                                mysqli_stmt_execute($stmt);
                                $result2 = mysqli_stmt_get_result($stmt);

                                if ( mysqli_num_rows($result2) >= 1 ) {
                                    if ($row2 = $result2 -> fetch_assoc()) {
                                        if ($row2['student_total_time'] == NULL) {
                                            echo "<td>0</td>";
                                        } else {
                                            echo "<td>{$row2['student_total_time']}</td>"; 
                                        }
                                        if ($row2['student_transaction_count'] == NULL) {
                                            echo "<td>0</td>";
                                        } else {
                                            echo "<td>{$row2['student_transaction_count']}</td>"; 
                                        } 
                                    }
                                } else {
                                    echo "<td>0</td>";
                                    echo "<td>0</td>";  
                                }

                                $sql = "SELECT count(student_id) as student_items_completed
                                FROM student_tasks
                                WHERE completed_instructor_id = ? AND student_id = ?;";
                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "ii", $_SESSION["instructor"]["id"], $row['student_id']);
                                mysqli_stmt_execute($stmt);
                                $result3 = mysqli_stmt_get_result($stmt);

                                if ( mysqli_num_rows($result3) >= 1 ) {
                                    if ($row3 = $result3 -> fetch_assoc()) {
                                        echo "<td>{$row3['student_items_completed']}</td>";
                                    }
                                } else {
                                    echo "<td>0</td>";
                                }

                                echo "</tr>";

                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
