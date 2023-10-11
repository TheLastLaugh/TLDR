<?php
// Initialize session data
session_start();

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
// If the user is an instructor, don't give them access to this page
else if ($_SESSION['user_type'] == 'instructor') {
    header("Location: ../dashboard/welcome-qsd.php");
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
    <title>TLDR For Qualified Supervised Driver</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div id="content">
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
                            echo "<a href='../search/selectuser.php?username=-1&usertype=learner'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x' viewBox='0 0 16 16'>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Clear Student</a> ";
                            echo "<a href='../search/search.php?usertype=student'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                            </svg> Change Student</a><br>";
                            echo "<p>Student Name: {$studentname}</p>
                            <ul>
                                <li>Address: {$studentaddress}</li>
                                <li>Age: {$studentage}</li>
                                <li>Contact Number: {$studentnumber}</li>
                            </ul>";
                            echo "<a href='../students/logbook.php'>View Logbook</a><br>";
                            echo '<a href="../logbooks/logbook-entry.php">Add a new logbook entry</a><br>';
                        } else {
                            $studentname = "No Student Selected";
                            echo "<p>Student Name: {$studentname}</p>";
                            echo "<a href='../search/search.php?usertype=student'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                            </svg> Search Student</a><br>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>  
</body>

</html>
