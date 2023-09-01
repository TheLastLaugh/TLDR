<?php
require_once "../inc/dbconn.inc.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = $_POST['address'];
    $license = $_POST['license'];
    $dob = $_POST['dob'];

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $sql = "INSERT INTO users (username, password, address, license, dob, user_type) VALUES (?, ?, ?, ?, ?, 'learner')";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $username, $hashed_password, $address, $license, $dob);

    header("Location: /dashboard/welcome.php");
}
?>
