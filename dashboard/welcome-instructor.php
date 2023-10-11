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
    if(isset($_SESSION['student']['username'])){
        $placeholder = $_SESSION['student']['username'];
    } else {
        $placeholder = null;
    }
    if($result["username"] != $placeholder){
        echo('<a href = ../search/selectuser.php?id=' . $learner_id . ' >' . $result["username"] . ' </a>');
    }
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
    <script src="./welcome.js"></script>
    
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
                            echo "<a href='../search/selectuser.php?username=-1&usertype=learner'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x' viewBox='0 0 16 16'>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Clear Student</a> ";
                            echo "<a href='../search/search.php?usertype=student'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                            </svg> Change Student</a> ";
                            echo "<a href='../login/learner-login.php'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-add' viewBox='0 0 16 16'>
                            <path d='M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'/>
                            <path d='M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z'/>
                          </svg> Create New Student</a>";
                            echo "<p>Student Name: {$studentname}</p>";
                            echo "<ul>
                                <li>Address: {$studentaddress}</li>
                                <li>Age: {$studentage}</li>
                                <li>Contact Number: {$studentnumber}</li>
                            </ul>";
                            echo '<a href="../logbooks/logbook-entry.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                          </svg> Add a new logbook entry</a><br>';
                            echo '<a href="../instructors/issue-bill.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                            <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
                          </svg> Issue Bill</a><br><br>';
                        } else {
                            $studentname = "No Student Selected";
                            echo "<p>Student Name: {$studentname}</p>";
                            echo "<a href='../search/search.php?usertype=student'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-search' viewBox='0 0 16 16'>
                            <path d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/>
                            </svg> Search Student</a><br>";
                            echo "<a href='../login/learner-login.php'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-add' viewBox='0 0 16 16'>
                            <path d='M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'/>
                            <path d='M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z'/>
                          </svg> Create New Student</a>";
                        }
                    ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
