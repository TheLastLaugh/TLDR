<?php
// Initialise session
session_start();

// Add the database connection
// require_once "../inc/dbconn.inc.php";

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
}

// If the user is a learner, don't give them access to this page
// else if ($_SESSION['user_type'] != 'government' || $_SESSION['user_type'] != 'instructor') {

//     // If the user is a learner, don't give them access to this page
//     if ($_SESSION['user_type'] == 'learner') {
//         header("Location: ../dashboard/welcome.php");
//         exit;
//     }

//     // If the user is a qsd, don't give them access to this page
//     else if ($_SESSION['user_type'] == 'qsd') {
//         header("Location: ../dashboard/welcome-qsd.php");
//         exit;
//     }

//     else {
//         exit;
//     }

// }

else if ($_SESSION['user_type'] == 'instructor') {
    $selectedUserType = "learner";
    $selectedUsername = $_POST['username'];
}

else if ($_SESSION['user_type'] == 'government') {
    $selectedUserType = $_POST['usertype'];
    $selectedUsername = $_POST['username'];
}


// $_SESSION["student-username"] = 'test';
// $_SESSION["instructor-username"] = 'test';

if ($selectedUserType == 'learner') {
    $_SESSION["student-username"] = $selectedUsername;
} elseif ($selectedUserType == 'instructor') {
    $_SESSION["instructor-username"] = $selectedUsername;
} 


//Close the connection and terminate the script.
// mysqli_close($conn);
// exit();

?>