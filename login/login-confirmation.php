<?php
// Initialise session
session_start();

// add the database connection
require_once "../inc/dbconn.inc.php";

// debugging late at night
echo 'we out here';

// Check if form is submitted
if (isset($_POST['email']) && isset($_POST['password'])) {
    // lol
    echo 'we in here';

    // Get the user's email and password from submitted form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email exists in database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Check if password is correct
        if (password_verify($password, $row['password'])) {
            // Password is correct; Start session
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_type'] = $row['user_type'];

            header("Location: ../dashboard/welcome.php");
            exit;
        } else {
            // Set error message
            session_start();
            $_SESSION['login_error'] = "Incorrect email or password. Please try again.";
            header("Location: ./index.php?error=incorrect_password");
            exit();
        }
    } else {
        // Set error message
        session_start();
        $_SESSION['login_error'] = "Incorrect email or password. Please try again.";
        header("Location: ./index.php?error=email_not_found");
        exit();
    }
}

// Close the connection and terminate the script
mysqli_close($conn);
exit();
?>
