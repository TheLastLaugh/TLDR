<?php
// initialise session
session_start();

// add the database connection
require_once "../inc/dbconn.inc.php";

// If the user enters incorrect details, an error will be added to the url via ?error=<error>
// Check if there is one, and if so, display the appropriate error message
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == "email_not_found") {
        $error_msg = "Email not found. Please try again.";
    } else if ($error == "incorrect_password") {
        $error_msg = "Incorrect password. Please try again.";
    }
    // lol this might be a terrible way to do this but I'm tired and it's 2am
    echo '<script>alert("' . $error_msg . '")</script>';
}
?>

<!-- Default landing page for the website, allows the user to log in, or sign up for a new account -->
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
          Welcome to the TLDR. Online service to input your driving lessons and
          hours at ease.
        </p>
      </div>
      <div class="login">
        <h2>Sign In</h2>
        <!-- After the user enters the details, the form gets submitted to a confirmation script, which checks the validity of their details -->
        <!-- They will either be redirected to the dashboard, or sent back here with an error -->
        <!-- IMPORTANT - I still need to go through the login and signup to make sure that passwords have a minimum security level, but I haven't looked into it yet. -->
        <form action="login-confirmation.php" method="POST">
          <div class="input-box">
            <span class="icon">
              <i class="fa-solid fa-envelope"></i>
            </span>
            <input type="email" class="input" name="email" id="user-input" placeholder="Enter your email" autocomplete="off" required /> 
          </div>
          <div class="input-box">
            <span class="icon">
              <i class="fa-solid fa-lock"></i>
              <input type="password" class="input" name="password" id="user-input" placeholder="Enter your password" autocomplete="off" required />
            </span>
          </div>

          <!-- Currently these have no implementation -->
          <div class="remember-forgot">
            <label> <input type="checkbox" />Remember me</label>
            <a href="#">Forgot Password?</a>
          </div>
          <button type="submit">Login</button>

          <!-- This will direct the user to a link that lets them register their account appropriately -->
          <div class="register-link">
            <p><strong>Not a member?</strong></p>
            <br />

            <a
              href="./user-choice.php"
              >Sign up now</a
            >
          </div>
        </form>
      </div>
    </section>
  </body>
</html>