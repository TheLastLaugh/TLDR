<?php
// initialise session
session_start();

// add the database connection
require_once "../inc/dbconn.inc.php";

// If the form was submitted, update the user info
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST['email'];
    $new_address = $_POST['address'];
    
    // Check if the new email is unique
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $new_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // If the email is already in use, redirect to the profile page with an error message. If the email is being used by the same user, do nothing
    if (($row = mysqli_fetch_assoc($result)) && $row['id'] != $_SESSION['userid']) {
        session_start();
        $_SESSION['login_error'] = "This email is already in use. Please try again.";
        header("Location: ./profile.php?error=incorrect_email");
        exit();
    }

    // Update the user info
    $stmt = mysqli_prepare($conn, "UPDATE users SET email = ?, address = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $new_email, $new_address, $_SESSION['userid']);
    mysqli_stmt_execute($stmt);

    // Update the instructor info if the user is an instructor
    if ($_SESSION['user_type'] == 'instructor') {
        $new_company = $_POST['company'];
        $new_company_address = $_POST['company_address'];
        $new_phone = $_POST['phone'];
        $new_price = $_POST['price'];

        $stmt = mysqli_prepare($conn, "UPDATE instructors SET company = ?, company_address = ?, phone = ?, price = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "ssssi", $new_company, $new_company_address, $new_phone, $new_price, $_SESSION['userid']);
        mysqli_stmt_execute($stmt);
    }

    // Update the QSD info if the user is a QSD
    if ($_SESSION['user_type'] == 'qsd') {
        $valid_licenses = [];
        $invalid_licenses = [];

        for ($i = 0; $i < count($_POST['learners']); $i++) {
            $learner_id = $_POST['learners'][$i];

            if (empty($learner_id)) {
                continue;
            }

            $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE license = ?");
            mysqli_stmt_bind_param($stmt, "i", $learner_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$row = mysqli_fetch_assoc($result)) {
                $invalid_licenses[] = $learner_id;
            } else {
                $valid_licenses[] = $learner_id;
            }
        }

        foreach ($valid_licenses as $learner_id) {
            $sql = "SELECT ql.learner_id 
            FROM qsd_learners AS ql
            JOIN users AS u ON ql.learner_id = u.id
            WHERE u.license = ? AND ql.qsd_id = ?;
            ";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $learner_id, $_SESSION['userid']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$row = mysqli_fetch_assoc($result)) {
                $sql = "SELECT id FROM users WHERE license = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $learner_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $learner_id = $row['id'];
                echo $learner_id;

                $sql = "INSERT INTO qsd_learners (qsd_id, learner_id) VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ii", $_SESSION['userid'], $learner_id);
                mysqli_stmt_execute($stmt);
                echo "inserted";
            }
        }

        if (!empty($invalid_licenses)) {
            echo "invalid";
            header("Location: ./profile.php?error=invalid_licenses&licenses=" . implode(",", $invalid_licenses));
            exit();
        }
    }

    // Redirect to the profile page
    header("Location: ./profile.php");

    // Close the connection and terminate the script
    mysqli_close($conn);
    exit();
}
?>