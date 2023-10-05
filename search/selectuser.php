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

//     // If the user is a qsd, don't give them access to this page
//     else if ($_SESSION['user_type'] == 'qsd') {
//         header("Location: ../dashboard/welcome-qsd.php");
//         exit;
//     }

//     else {
//         exit;
//     }

// }

else if ($_SESSION['user_type'] == 'qsd') {
    $selectedUserType = "learner";
    $selectedUsername = $_POST['username'];
}

else if ($_SESSION['user_type'] == 'instructor') {
    $selectedUserType = "learner";
    $selectedUsername = $_POST['username'];
}

else if ($_SESSION['user_type'] == 'government') {
    $selectedUserType = $_POST['usertype'];
    $selectedUsername = $_POST['username'];
}


if ($selectedUserType == 'learner') {

    $sql = "SELECT id, username, license, dob, address, contact_number FROM users WHERE user_type = 'learner' AND id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $selectedUsername);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ( mysqli_num_rows($result) >= 1 ) {
        $row = $result -> fetch_assoc();
        $_SESSION["student"]["id"] = $row["id"];
        $_SESSION["student"]["license"] = $row["license"];
        $_SESSION["student"]["username"] = $row["username"];
        $_SESSION["student"]["dob"] = $row["dob"];
        $_SESSION["student"]["address"] = $row["address"];
        $_SESSION["student"]["contact_number"] = $row["contact_number"];
    }

} elseif ($selectedUserType == 'instructor') {

    $sql = "SELECT id, username, license, dob, address, contact_number FROM users WHERE user_type = 'instructor' AND id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $selectedUsername);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ( mysqli_num_rows($result) >= 1 ) {
        $row = $result -> fetch_assoc();
        $_SESSION["instructor"]["id"] = $row["id"];
        $_SESSION["instructor"]["license"] = $row["license"];
        $_SESSION["instructor"]["username"] = $row["username"];
        $_SESSION["instructor"]["dob"] = $row["dob"];
        $_SESSION["instructor"]["address"] = $row["address"];
        $_SESSION["instructor"]["contact_number"] = $row["contact_number"];
    }

} elseif ($selectedUserType == 'qsd') {

    $sql = "SELECT id, username, license, dob, address, contact_number FROM users WHERE user_type = 'qsd' AND id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $selectedUsername);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ( mysqli_num_rows($result) >= 1 ) {
        $row = $result -> fetch_assoc();
        $_SESSION["qsd"]["id"] = $row["id"];
        $_SESSION["qsd"]["license"] = $row["license"];
        $_SESSION["qsd"]["username"] = $row["username"];
        $_SESSION["qsd"]["dob"] = $row["dob"];
        $_SESSION["qsd"]["address"] = $row["address"];
        $_SESSION["qsd"]["contact_number"] = $row["contact_number"];
    }

} 




//Close the connection and terminate the script.
// mysqli_close($conn);
// exit();

?>