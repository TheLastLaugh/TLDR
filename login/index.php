<?php
session_start();
require_once "../inc/dbconn.inc.php";

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == "email_not_found") {
        $error_msg = "Email not found. Please try again.";
    } else if ($error == "incorrect_password") {
        $error_msg = "Incorrect password. Please try again.";
    }
    echo '<script>alert("' . $error_msg . '")</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/welcome.css" />
    <title>TLDR</title>
  </head>
  <body>
    <header class="header">
      <a href="#" class="logo" class="fa-solid fa-globe"><i>TLDR</i> </a>
    </header>

    <section class="home">
      <div class="content">
        <h2>Welcome</h2>
        <p>
          Welcome to the TLDR. Online serive to input your driving lessons and
          hours at ease.
        </p>
      </div>
      <div class="login">
        <h2>Sign In</h2>
        <form action="login-confirmation.php" method="POST">
          <div class="input-box">
            <span class="icon">
              <i class="fa-solid fa-envelope"></i>
            </span>
            <input type="text" class="input" name="email" id="user-input" placeholder="Enter your email" autocomplete="off" required /> 
          </div>
          <div class="input-box">
            <span class="icon">
              <i class="fa-solid fa-lock"></i>
              <input type="password" class="input" name="password" id="user-input" placeholder="Enter your password" autocomplete="off" required />
            </span>
          </div>
          <div class="remember-forgot">
            <label> <input type="checkbox" />Remember me</label>
            <a href="#">Forgot Password?</a>
          </div>
          <button type="submit">Login</button>
          <div class="register-link">
            <p><strong>Not a member?</strong></p>
            <br />

            <a
              href="./learner-or-instructor.php"
              >Sign up now</a
            >
          </div>
        </form>
      </div>
    </section>
  </body>
</html>