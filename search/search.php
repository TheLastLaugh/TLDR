<?php
// Initialise session
session_start();

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

// Add the database connection
require_once "../inc/dbconn.inc.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Jordan Prime" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="../styles/search.css"/>
    <script type="text/javascript" src="./search.js" defer></script>
</head>
<body>
    <!-- <div id="banner">Search Student</div> -->
    
    <?php include_once "../inc/sidebar.inc.php"; ?>

    <br>

    <?php

        if ($_SESSION['user_type'] == 'instructor') {

            echo '<form>
                <label for="searchby">Search By:</label><br>
                <input type="radio" id="existing" name="searchby" value="existing" checked>
                <label for="html">Existing Students</label><br>
                <input type="radio" id="name-dob" name="searchby" value="name-dob">
                <label for="html">Name</label><br>
                <input type="radio" id="dl" name="searchby" value="dl">
                <label for="css">Drivers License</label><br>
            </form>
        
            <br>
        
            <form id="search-name">
                <input type="text" id="fname" name="fname" placeholder="Enter name here" required><br><br>
                <input type="reset" value="Clear">
                <input type="submit" value="Search"><br><br>
            </form>
        
            <form id="search-dl">
                <input type="text" id="dlnumber" name="dlnumber" placeholder="Enter drivers license here" required><br><br>
                <input type="reset" value="Clear">
                <input type="submit" value="Search"><br><br>
            </form>

            <table id="studentsTable">
                <tr>
                    <th>Full Name</th>
                    <th>Drivers License</th>
                    <th>Date of Birth</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                </tr>
                <tr>
                    <td colspan="5">Please search a student above</td>
                </tr>
            </table>';

        } elseif ($_SESSION['user_type'] == 'government') {

            echo '
            <form>
                <label for="userType">Select User Type:</label><br>
                <input type="radio" id="student" name="userType" value="student" checked>
                <label for="student">Student (Learner Driver)</label><br>
                <input type="radio" id="instructor" name="userType" value="instructor">
                <label for="instructor">Instructor</label><br><br>
                <label for="searchby">Search By:</label><br>
                <input type="radio" id="name-dob" name="searchby" value="name-dob" checked>
                <label for="html">Name</label><br>
                <input type="radio" id="dl" name="searchby" value="dl">
                <label for="css">Drivers License</label><br>
            </form>
        
            <br>
        
            <form id="search-name">
                <input type="text" id="fname" name="fname" placeholder="Enter name here" required><br><br>
                <input type="hidden" id="usertype1" name="usertype1" value="student">
                <input type="reset" value="Clear">
                <input type="submit" value="Search"><br><br>
            </form>
        
            <form id="search-dl">
                <input type="text" id="dlnumber" name="dlnumber" placeholder="Enter drivers license here" required><br><br>
                <input type="hidden" id="usertype2" name="usertype2" value="student">
                <input type="reset" value="Clear">
                <input type="submit" value="Search"><br><br>
            </form>

            <table id="studentsTable">
                <tr>
                    <th>Full Name</th>
                    <th>Drivers License</th>
                    <th>Date of Birth</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                </tr>
                <tr>
                    <td colspan="5">Please search a student above</td>
                </tr>
            </table>';

        }

    ?>

</body>
</html>
