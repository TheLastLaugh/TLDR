<?php
// Initialize session data
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
} 
// If the user is not government, don't give them access to this page
else if ($_SESSION['user_type'] != 'government') {
    // If the user is a learner, redirect
    if ($_SESSION['user_type'] == 'learner') {
        header("Location: ../dashboard/welcome.php");
        exit;
    }
    // If the user is a qsd, redirect
    else if ($_SESSION['user_type'] == 'qsd') {
        header("Location: ../dashboard/welcome-qsd.php");
        exit;
    }
    // If the user is an instructor, redirect
    else if ($_SESSION['user_type'] == 'instructor') {
        header("Location: ../dashboard/welcome-instructor.php");
        exit;
    } else {
        exit;
    }
}
?>
<!-- Super simple dashboard page for now, we can update this with anything we want -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Jordan Prime"; />
    <title>TLDR for Government</title>
    <link rel="stylesheet" href="../styles/styles.css">
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
                            $studentlicense = $_SESSION['student']['license'];
                            $studentaddress = $_SESSION['student']['address'];
                            $studentdob = date("d/m/Y", strtotime($_SESSION['student']['dob']));
                            $studentage = date_diff(date_create(date("Y-m-d")), date_create($_SESSION['student']['dob']));
                            $studentage = $studentage->format('%y');
                            $studentnumber = $_SESSION['student']['contact_number'];
                            echo "<a href='../search/selectuser.php?username=-1&usertype=learner'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x' viewBox='0 0 16 16'>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Clear Student</a> ";
                            echo "<a href='../search/search.php?usertype=student'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                            </svg> Change Student</a> ";
                            echo "<a href='../login/learner-login.php'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-add' viewBox='0 0 16 16'>
                            <path d='M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'/>
                            <path d='M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z'/>
                          </svg> Create New Student</a><br>";
                            echo "<p>Name: {$studentname}</p>
                            <ul>
                                <li>Drivers License: {$studentlicense}</li>
                                <li>Address: {$studentaddress}</li>
                                <li>Date of Birth: {$studentdob} ( Age: {$studentage} )</li>
                                <li>Contact Number: {$studentnumber}</li>
                            </ul>
                            <a href='../students/logbook.php'>View Logbook</a><br>
                            <a href='../students/cbt&a.php'>CBT&A Items</a>
                            ";
                        } else {
                            $studentname = "No Student Selected";
                            echo "<p>Student Name: {$studentname}</p>";
                            echo "<a href='../search/search.php?usertype=student'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                            </svg> Search Student</a><br>";
                            echo "<a href='../login/learner-login.php'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-add' viewBox='0 0 16 16'>
                            <path d='M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'/>
                            <path d='M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z'/>
                          </svg> Create New Student</a><br>";
                        }
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Instructors</h3>
                    <?php
                        if (isset($_SESSION['instructor'])) {
                            $instructorname = $_SESSION['instructor']['username'];
                            $instructorlicense = $_SESSION["instructor"]["license"];
                            $instructoraddress = $_SESSION["instructor"]["address"];
                            $instructordob = date("d/m/Y", strtotime($_SESSION["instructor"]["dob"]));
                            $instructorage = date_diff(date_create(date("Y-m-d")), date_create($_SESSION["instructor"]["dob"]));
                            $instructorage = $instructorage->format('%y');
                            $instructornumber = $_SESSION["instructor"]["contact_number"];
                            echo "<a href='../search/selectuser.php?username=-1&usertype=instructor'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x' viewBox='0 0 16 16'>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Clear Instructor</a> ";
                            echo "<a href='../search/search.php?usertype=instructor'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                            </svg> Change Instructor</a> ";
                            echo "<a href='../login/instructor-login.php'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-add' viewBox='0 0 16 16'>
                            <path d='M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'/>
                            <path d='M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z'/>
                          </svg> Create New Instructor</a> ";
                            echo "<p>Name: {$instructorname}</p>
                            <ul>
                                <li>Drivers License: {$instructorlicense}</li>
                                <li>Address: {$instructoraddress}</li>
                                <li>Date of Birth: {$instructordob} ( Age: {$instructorage} )</li>
                                <li>Contact Number: {$instructornumber}</li>
                            </ul>
                            <a href='../instructors/report.php'>View Report</a>
                            ";
                        } else {
                            $instructorname = "No Instructor Selected";
                            echo "<p>Instructor Name: {$instructorname}</p>";
                            echo "<a href='../search/search.php?usertype=instructor'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                            </svg> Search Instructor</a><br>";
                            echo "<a href='../login/instructor-login.php'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-add' viewBox='0 0 16 16'>
                            <path d='M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'/>
                            <path d='M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z'/>
                          </svg> Create New Instructor</a><br>";
                        }
                    ?>
                </div>
                <div class="stat-card">
                    <h3>Qualified Supervising Drivers (QSD)</h3>
                    <?php
                        if (isset($_SESSION['qsd'])) {
                            $qsdname = $_SESSION['qsd']['username'];
                            $qsdlicense = $_SESSION["qsd"]["license"];
                            $qsdaddress = $_SESSION["qsd"]["address"];
                            $qsddob = date("d/m/Y", strtotime($_SESSION["qsd"]["dob"]));
                            $qsdage = date_diff(date_create(date("Y-m-d")), date_create($_SESSION["qsd"]["dob"]));
                            $qsdage = $qsdage->format('%y');
                            $qsdnumber = $_SESSION["qsd"]["contact_number"];
                            echo "<a href='../search/selectuser.php?username=-1&usertype=qsd'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x' viewBox='0 0 16 16'>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Clear QSD</a> ";
                            echo "<a href='../search/search.php?usertype=qsd'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                            </svg> Change QSD</a> ";
                            echo "<a href='../login/qsd-login.php'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-add' viewBox='0 0 16 16'>
                            <path d='M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'/>
                            <path d='M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z'/>
                          </svg> Create New QSD</a><br>";
                            echo "<p>Name: {$qsdname}</p>
                            <ul>
                                <li>Drivers License: {$qsdlicense}</li>
                                <li>Address: {$qsdaddress}</li>
                                <li>Date of Birth: {$qsddob} ( Age: {$qsdage} )</li>
                                <li>Contact Number: {$qsdnumber}</li>
                            </ul>
                            ";
                        } else {
                            $qsdname = "No QSD Selected";
                            echo "<p>Qualified Supervising Driver: {$qsdname}</p>";
                            echo "<a href='../search/search.php?usertype=qsd'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                            </svg> Search QSD</a><br>";
                            echo "<a href='../login/qsd-login.php'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-add' viewBox='0 0 16 16'>
                            <path d='M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'/>
                            <path d='M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z'/>
                          </svg> Create New QSD</a><br>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
