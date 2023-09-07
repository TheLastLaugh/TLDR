<?php
// Initialise session
session_start();

// Add the database connection
require_once "../inc/dbconn.inc.php";

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
}

// If the user is a learner, don't give them access to this page
else if ($_SESSION['user_type'] == 'learner') {
    header("Location: ../dashboard/welcome.php");
    exit;
}

// If the user is a qsd, don't give them access to this page
else if ($_SESSION['user_type'] == 'qsd') {
    header("Location: ../dashboard/welcome-qsd.php");
    exit;
}

else if ($_SESSION['user_type'] == 'instructor') {
    $searchType = 'student';
    $searchBy = $_POST['search'];
}

else if ($_SESSION['user_type'] == 'government') {
    $searchType = $_POST['type'];
    $searchBy = $_POST['search'];
}


$data = array();

// Get the matching students for the search
if ($searchBy == 'name' && $searchType == 'student' && ($_SESSION['user_type'] == 'instructor' || $_SESSION['user_type'] == 'government')) {
    $student_fullname = $_POST['fname'];
    $sql = "SELECT username, license, dob, address FROM users WHERE user_type = 'learner' AND username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $student_fullname);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ( mysqli_num_rows($result) >= 1 ) {
        while ( $row = mysqli_fetch_assoc($result) ) {
            array_push($data, $row);
        }
    }
    mysqli_free_result($result);
} elseif ($searchBy == 'name' && $searchType == 'instructor' && $_SESSION['user_type'] == 'government' ) {
    $student_fullname = $_POST['fname'];
    $sql = "SELECT username, license, dob, address FROM users WHERE user_type = 'instructor' AND username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $student_fullname);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ( mysqli_num_rows($result) >= 1 ) {
        while ( $row = mysqli_fetch_assoc($result) ) {
            array_push($data, $row);
        }
    }
    mysqli_free_result($result);
} elseif ($searchBy == 'dl' && $searchType == 'student' && ($_SESSION['user_type'] == 'instructor' || $_SESSION['user_type'] == 'government')) {
    $student_dl = $_POST['license'];
    $sql = "SELECT username, license, dob, address FROM users WHERE user_type = 'learner' AND license = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $student_dl);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ( mysqli_num_rows($result) >= 1 ) {
        while ( $row = mysqli_fetch_assoc($result) ) {
            array_push($data, $row);
        }
    }
    mysqli_free_result($result);
} elseif ($searchBy == 'dl' && $searchType == 'instructor' && $_SESSION['user_type'] == 'government') {
    $student_dl = $_POST['license'];
    $sql = "SELECT username, license, dob, address FROM users WHERE user_type = 'instructor' AND license = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $student_dl);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ( mysqli_num_rows($result) >= 1 ) {
        while ( $row = mysqli_fetch_assoc($result) ) {
            array_push($data, $row);
        }
    }
    mysqli_free_result($result);
} elseif ($searchBy == 'existing' && $_SESSION['user_type'] == 'instructor') {
    // $student_dl = $_POST['license'];
    // $sql = "SELECT username, license, dob, address FROM users WHERE user_type = 'learner' AND license = ?";
    $sql = "SELECT username, license, dob, address FROM users LEFT JOIN instructor_learners ON instructor_learners.learner_id = users.id WHERE users.user_type = 'learner' AND instructor_learners.instructor_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['userid']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ( mysqli_num_rows($result) >= 1 ) {
        while ( $row = mysqli_fetch_assoc($result) ) {
            array_push($data, $row);
        }
    }
    mysqli_free_result($result);
} 

//Return JSON list of learner drivers found in search
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);

//Close the connection and terminate the script.
mysqli_close($conn);
exit();

?>