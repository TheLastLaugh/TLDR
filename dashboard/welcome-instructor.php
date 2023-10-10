<?php
// Initialize session data
session_start();


function getStudentDetails($learner_id, $conn){
    $studentSQL = "SELECT username FROM users WHERE id = ?";
    $studentSTATE = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($studentSTATE, $studentSQL);
    mysqli_stmt_bind_param($studentSTATE, "i", $learner_id);
    mysqli_stmt_execute($studentSTATE);
    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($studentSTATE));

    echo('<a href = ../search/selectuser.php?id=' . $learner_id . ' >' . $result["username"] . ' </a>');
    echo("<br>");

}

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
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

//Get Linked Students
require_once "../inc/dbconn.inc.php"; 
$sql = "SELECT learner_id FROM instructor_learners WHERE instructor_id = ?";
$statement = mysqli_stmt_init($conn);
mysqli_stmt_prepare($statement, $sql);
mysqli_stmt_bind_param($statement, "i", $_SESSION["userid"]);
mysqli_stmt_execute($statement);

$result = mysqli_stmt_get_result($statement);

?>
<!-- Super simple dashboard page for now, we can update this with anything we want -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alistair Macvicar"; />
    <meta name="author" content="Jordan Prime"; />
    <link rel="stylesheet" href="../styles/styles.css">
    
    <title>Home</title>
</head>
<body>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>

    <div id = "content">
        <div id="dashboard">
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Students</h3>
                    <?php
                        if (isset($_SESSION['student'])) {
                            $studentname = $_SESSION['student']['username'];
                            $studentnumber = $_SESSION['student']['contact_number'];
                            $studentaddress = $_SESSION['student']['address'];
                            $studentdob = $_SESSION['student']['dob'];
                            $studentage = date_diff(date_create(date("Y-m-d")), date_create($studentdob));
                            $studentage = $studentage->format('%y');
                            echo "<p>Student Name: {$studentname}</p>
                            <ul>
                                <li>Address: {$studentaddress}</li>
                                <li>Age: {$studentage}</li>
                                <li>Contact Number: {$studentnumber}</li>
                            </ul>";
                            echo '<a href="../logbooks/logbook-entry.php">Add a new logbook entry</a><br><br>';
                        } else {
                            $studentname = "No Student Selected";
                            echo "<p>Student Name: {$studentname}</p>";
                        }
                    ?>
                        <div class = "dropdown">
                            <button class = "dropbtn">Select Current Student</button>
                            <div id = "dropdown">
                            <?php while($row = mysqli_fetch_assoc($result)){ getStudentDetails($row["learner_id"], $conn);} ?>
                            <a href = "../search/selectuser.php?id=-1">Deselect</a><br>
                            <a href="../search/search.php?usertype=student">Change Student</a><br>
                            </div>
                        </div>
                </div>
                <div class="stat-card">
                    <h3>Billing</h3>
                    <a href="#">View Issued Bills</a><br>
                    <?php if(isset($_SESSION['student'])) {
                        echo('<a href="#">Issue Bill</a>');
                    }?>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
