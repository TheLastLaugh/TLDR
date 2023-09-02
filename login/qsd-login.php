<!-- Login page for new qsd accounts -->
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
    <script src="../scripts/qsdRegScript.js" defer></script>
</head>
<body>
    <div>
        <h1>Register</h1>
        <!-- Directs to the same registration page as all new accounts -->
        <!-- Fields to enter user information -->
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
                    <input type="password" name="password" id="password" required>
                </li>
                <li>
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
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
                    <label for="learners">License #s of who you are supervising</label>
                    <div id="learnerContainer">
                        <input type="text" name="learners[]" required>
                    </div>
                    <button type="button" id="addLearnerButton">Add more licenses</button>
                    <!-- this is hidden by default, it will show when there is more than 1 learner box -->
                    <button type="button" id="removeLearnerButton" style="display:none">Remove learner</button>
                </li>
                <li>
                    <input type="submit" value="Submit" class="submit-button">
                </li>

                <!-- A hidden field that will decide how the user is created when it is redirected -->
                <input type="hidden" name="user_type" value="qsd">
            </ul>
        </form>
    </div>
</body>
</html>