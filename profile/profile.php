<?php
// Initialise session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
}

// If there is an error, display it
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == "incorrect_email") {
        $error_msg = "This email is already in use. Please try again.";
    } else if ($error == 'invalid_licenses') {
        $error_msg = "License is not in our database. Please try again.";
    }
    echo '<script>alert("' . $error_msg . '")</script>';
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// add the database connection
require_once "../inc/dbconn.inc.php";

// get some of the user's details from the session
$user_id = $_SESSION['userid'];
$name = $_SESSION['username'];
$user_type = $_SESSION['user_type'];

// Grab the rest of the user's details from the database
$result = mysqli_query($conn, "SELECT email, address, license, dob FROM users WHERE id = $user_id");
$row = mysqli_fetch_assoc($result);
$email = $row['email'];
$address = $row['address'];
$license = $row['license'];
$dob = $row['dob'];

// Show the company infor the is the user is an instructor
if ($user_type == 'instructor') {
    $result = mysqli_query($conn, "SELECT company, company_address, phone, price FROM instructors WHERE user_id = $user_id");
    $row = mysqli_fetch_assoc($result);

    $company = $row['company'];
    $company_address = $row['company_address'];
    $phone = $row['phone'];
    $price = $row['price'];
} else if ($user_type == 'qsd') {
    $result = mysqli_query($conn, "SELECT learner_id FROM qsd_learners WHERE qsd_id = $user_id");
}
?>

<!-- Profile page that shows all of the user's information, and allows them to change some of it -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alistair Macvicar">
    <title>Profile</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../scripts/profileScript.js" defer></script>
</head>
<body>
    <!-- include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div id="content">
    <div id = "profile-content">
        <form id="editForm" action="update-profile.php" method="post">
            <!-- Name (can't edit) -->
            <p class="detail"><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>

            <!-- Email -->
            <p class="detail"><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <div class="edit-field" style="display: none;">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <!-- Address -->
            <p class="detail"><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
            <div class="edit-field" style="display: none;">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($address); ?>" required>
            </div>

            <!-- License (can't edit) -->
            <p class="detail"><strong>License:</strong> <?php echo htmlspecialchars($license); ?></p>

            <!-- Date of Birth (can't edit) -->
            <p class="detail"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($dob); ?></p>

            <!-- Instructor Details -->
            <?php if ($user_type == 'instructor'): ?>
            <h2>Instructor Details</h2>
            
            <!-- Company -->
            <p class="detail"><strong>Company:</strong> <?php echo htmlspecialchars($company); ?></p>
            <div class="edit-field" style="display: none;">
                <label for="company">Company:</label>
                <input type="text" name="company" id="company" value="<?php echo htmlspecialchars($company); ?>" required>
            </div>
            
            <!-- Company Address -->
            <p class="detail"><strong>Company Address:</strong> <?php echo htmlspecialchars($company_address); ?></p>
            <div class="edit-field" style="display: none;">
                <label for="company_address">Company Address:</label>
                <input type="text" name="company_address" id="company_address" value="<?php echo htmlspecialchars($company_address); ?>" required>
            </div>
            
            <!-- Phone -->
            <p class="detail"><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
            <div class="edit-field" style="display: none;">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
            </div>
            
            <!-- Price -->
            <p class="detail"><strong>Price:</strong> <?php echo htmlspecialchars($price); ?></p>
            <div class="edit-field" style="display: none;">
                <label for="price">Price:</label>
                <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($price); ?>" required>
            </div>
            
            
            <!-- <div id="button-container">
                <input id = "updateProfile" type="submit" value="Update">
                </form>
                <button id="editButton">Edit Profile</button>
            </div> -->
            <?php endif; ?>

        <!-- QSD Details -->
        <?php if ($user_type == 'qsd'): ?>
        <h2>QSD Details</h2>
        
        <!-- Learners -->
        <p><strong>Learners:</strong>
        <?php
                // Store the learner ids in an array
                $learner_ids = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($learner_ids, $row['learner_id']);
                    $sql = "SELECT username FROM users WHERE id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $row['learner_id']);
                    mysqli_stmt_execute($stmt);
                    $nameResult = mysqli_stmt_get_result($stmt);
                    $nameRow = mysqli_fetch_assoc($nameResult);

                    $learners = $nameRow['username'];
                    echo htmlspecialchars($learners);
                }
            ?></p>
        <div class="edit-field" style="display: none;">
            <button type="button" id="addLearner">Add a Learner</button>
            <div id="learnerInputs">
                
            </div>
        </div>
        
        
        <?php endif; ?>
        <input id = "updateProfile" type="submit" value="Update">
        </form>
        <button id="editButton">Edit Profile</button>
        
        
    </div>
    </div>
</body>
</html>

