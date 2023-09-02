<?php
// initialise session
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// add the database connection
require_once "../inc/dbconn.inc.php";

// Check if email already exists
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Email already exists, redirect to login page
        header("Location: ./login-redirect.php?error=incorrect_email");
        exit();
    }
    
    // Check if the license already exists
    $license = $_POST['license'];

    $sql = "SELECT id FROM users WHERE license = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $license);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // license already exists, redirect to login page
        header("Location: ./login-redirect.php?error=incorrect_license");
        exit();
    }

    // Check if form is submitted
    echo 'form submitted';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = $_POST['address'];
    $license = $_POST['license'];
    $dob = $_POST['dob'];
    $user_type = $_POST['user_type'];
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $sql = "INSERT INTO users (username, email, password, address, license, dob, user_type) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $username, $email, $hashed_password, $address, $license, $dob, $user_type);

    mysqli_stmt_execute($stmt);

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);

    // Set session variables
    $_SESSION['loggedin'] = true;
    $_SESSION['userid'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['user_type'] = $row['user_type'];

    // Add a new entry to the instructor table if the new user is an instructor
    if ($user_type == 'instructor') {
        // Get the instructor's details from the form
        $company = $_POST['company'];
        $company_address = $_POST['company_address'];
        $company_phone = $_POST['company_phone'];
        $price = $_POST['price'];

        // Get the user's new id from the database
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];

        // Insert the instructor's details into the database
        $sql = "INSERT INTO instructors (username, user_id, company, company_address, phone, price) VALUES (?, ?, ?, ?, ?, ?);";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sisssi", $username, $user_id, $company, $company_address, $company_phone, $price);
        
        mysqli_stmt_execute($stmt);

        // Redirecto to the page that will add the default availability blocks
        header("Location: ./add-instructor-availability.php");
        exit();
    }

    // Add learner-qsd relations to the database if the new user is a qsd
    if ($user_type == 'qsd') {
        // Get the learner licenses from the form
        $learners = $_POST['learners'];

        // Check if the licenses are valid
        $invalid_licenses = [];
        $valid_ids = [];

        foreach($learners as $license) {
            $sql = "SELECT id FROM users WHERE license = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $license);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        
            if (mysqli_num_rows($result) == 0) {
                $invalid_licenses[] = $license;
            } else {
                $row = mysqli_fetch_assoc($result);
                $valid_ids[] = $row['id'];
            }
        }

        if (!empty($invalid_licenses)) {
            $sql = "DELETE FROM users WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['userid']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            header("Location: ./login-redirect.php?error=invalid_licenses&licenses=" . implode(",", $invalid_licenses));
            exit();
        }

        foreach($valid_ids as $license) {            
            // Add the relationship to the table
            $sql = "INSERT INTO qsd_learners (qsd_id, learner_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $_SESSION['userid'], $license);
            mysqli_stmt_execute($stmt);
        }

    }

    // Redirect to the dashboard
    header("Location: ../dashboard/welcome.php");
}

// Close the connection and terminate the script
mysqli_close($conn);
exit();
?>
