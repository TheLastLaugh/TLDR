<!-- Error page if the user tries to sign up with an email that's already in use -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alistair Macvicar">
    <title>Duplicate Email</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../scripts/loginScript.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Duplicate Email Detected!</h1>
        <p>The email you've provided is already registered. Please use a different email or <a href="./index.php">login here</a>.</p>

        <!-- Button that sends the user back to the previous page (from experimenting, this keeps the data they've put into the form so that they don't have to redo it) -->
        <button id="go_back">Go Back to Registration</button>
    </div>
</body>
</html>
