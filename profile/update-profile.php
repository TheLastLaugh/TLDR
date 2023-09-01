<?php
session_start();
require_once "../inc/dbconn.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST['email'];
    $new_address = $_POST['address'];
    
    // Check if the new email is unique
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $new_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        session_start();
        $_SESSION['login_error'] = "This email is already in use. Please try again.";
        header("Location: ./profile.php?error=incorrect_email");
        exit();
    }

    // Update the user info
    $stmt = mysqli_prepare($conn, "UPDATE users SET email = ?, address = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $new_email, $new_address, $_SESSION['userid']);
    mysqli_stmt_execute($stmt);

    if ($_SESSION['user_type'] == 'instructor') {
        $new_company = $_POST['company'];
        $new_company_address = $_POST['company_address'];
        $new_phone = $_POST['phone'];
        $new_price = $_POST['price'];

        $stmt = mysqli_prepare($conn, "UPDATE instructors SET company = ?, company_address = ?, phone = ?, price = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "ssssi", $new_company, $new_company_address, $new_phone, $new_price, $_SESSION['userid']);
        mysqli_stmt_execute($stmt);
    }

    header("Location: ./profile.php");
    mysqli_close($conn);
    exit();
}
?>