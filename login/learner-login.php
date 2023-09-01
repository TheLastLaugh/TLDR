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
</head>
<body>
    <div>
        <h1>Login with mySAGOV</h1>
        <a href="../mySAGovMockup/mySAGovMockup.html">
            <img src="../images/mySAGOV_logo.png" alt="mySAGOV logo" id="mySAGOV_link">
        </a>
        <h1>Register</h1>
        <form action="register.php" method="POST">
            <ul>
                <li>
                    <label for="name">Name</label>
                    <input type="text" name="username" required>
                </li>
                <li>
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </li>
                <li>
                    <label for="password">Password</label>
                    <input type="password" name="password" required>
                </li>
                <li>
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" required>
                </li>
                <li>
                    <label for="address">Address</label>
                    <input type="text" name="address" required>
                </li>
                <li>
                    <label for="license">License</label>
                    <input type="text" name="license" required>
                </li>
                <li>
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" required>
                </li>
                <li>
                    <input type="submit" value="Submit" class="submit-button">
                </li>
            </ul>
        </form>
    </div>
</body>
</html>