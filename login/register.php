<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        header("Location: ./login-redirect.php");
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

    $_SESSION['loggedin'] = true;
    $_SESSION['userid'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['user_type'] = $row['user_type'];

    if ($user_type == 'instructor') {
        echo 'instructor';
        $company = $_POST['company'];
        $company_address = $_POST['company_address'];
        $company_phone = $_POST['company_phone'];
        $price = $_POST['price'];

        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];

        $sql = "INSERT INTO instructors (username, user_id, company, company_address, phone, price) VALUES (?, ?, ?, ?, ?, ?);";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sisssi", $username, $user_id, $company, $company_address, $company_phone, $price);
        
        mysqli_stmt_execute($stmt);
        header("Location: ./add-instructor-availability.php");
    }

    header("Location: ../dashboard/welcome.php");
    exit();
}

mysqli_close($conn);
?>
