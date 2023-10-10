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

if (isset($_POST['hourly_rate_option']) && $_POST['hourly_rate_option'] == "system") {

    $sql = "SELECT price FROM instructors WHERE user_id = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ( mysqli_num_rows($result) >= 1 ) {
        if ($row = $result -> fetch_assoc()) {

            $hourly_rate = $row['price'];
            $duration = $_POST['duration'];
            $due_date = $_POST['due_date'];

            $sql="INSERT INTO bills (learner_id,instructor_id,issue_date,due_date,hourly_rate,billed_minutes) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iisssi", $_SESSION['student']['id'], $_SESSION['userid'], date('Y-m-d'), $due_date, $hourly_rate, $duration);
            mysqli_stmt_execute($stmt);

        }
    } 

} else if (isset($_POST['hourly_rate_option']) && $_POST['hourly_rate_option'] == "manual") {

    $duration = $_POST['duration'];
    $due_date = $_POST['due_date'];
    $hourly_rate = $_POST['hourly_rate'];

    $sql="INSERT INTO bills (learner_id,instructor_id,issue_date,due_date,hourly_rate,billed_minutes) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iisssi", $_SESSION['student']['id'], $_SESSION['userid'], date('Y-m-d'), $due_date, $hourly_rate, $duration);
    mysqli_stmt_execute($stmt);

}


?>