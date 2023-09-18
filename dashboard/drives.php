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
// If the user is not a learner, don't give them access to this page
else if ($_SESSION['user_type'] != 'learner') {
    header("Location: ../dashboard/welcome.php");
    exit;
}

// If the user is not a learner, don't give them access to this page
// elseif ($_SESSION['user_type'] != 'learner') {
//     header("Location: ../dashboard/welcome.php");
//     exit;
// }


$action = $_POST['action'];
$data = [];



if ($action == 'getdrives') {

    $sql = "SELECT * FROM logbooks WHERE learner_id = ? AND confirmed = 1;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ( mysqli_num_rows($result) >= 1 ) {
        while ($row = $result -> fetch_assoc()) {
            array_push($data, $row);
        }
    }

} 

header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);


// Close the connection and terminate the script.
mysqli_close($conn);
exit();

?>