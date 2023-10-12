<!-- Login page for new instructor accounts -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alistair Macvicar" />
    <title>Login</title>
    <link rel="stylesheet" href="../styles/login-styles.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../scripts/registrationScript.js" defer></script>
</head>
<body>
    <div>
        <h1 class="sagov-underline">Register</h1>
        <!-- Directs to the same registration page as all new accounts -->
        <!-- Fields to enter user information -->
        <form action="register.php" method="POST">
            <ul id="register-details">
                <li> <label for="name">Name</label> <input type="text" name="username" required> </li>
                <li> <label for="email">Email</label> <input type="email" name="email" required> </li>
                <li> <label for="password">Password</label> <input type="password" name="password" id="password" required> </li>
                <li> <label for="confirm_password">Confirm Password</label> <input type="password" name="confirm_password" id="confirm_password" required> </li>
                <li> <label for="address">Address</label> <input type="text" name="address" required> </li>
                <li> <label for="license">License</label> <input type="text" name="license" required> </li>
                <li> <label for="dob">Date of Birth</label> <input type="date" name="dob" required> </li>
                <li> <label for="company">Company</label> <input type="text" name="company" required> </li>
                <li> <label for="company">Company Address</label> <input type="text" name="company_address" required> </li>
                <li> <label for="company">Company Phone</label> <input type="text" name="company_phone" required> </li>
                <li> <label for="price">Price</label> <input type="text" name="price" required></li>
                <li class="centered">
                    <input type="submit" value="Submit" class="submit-button">
                </li>

                <!-- A hidden field that will decide how the user is created when it is redirected -->
                <input type="hidden" name="user_type" value="instructor">
            </ul>
        </form>
    </div>
</body>
</html>