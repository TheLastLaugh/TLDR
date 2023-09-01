<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == "incorrect_email") {
        $error_msg = "This email is already in use. Please try again.";
    }
    echo '<script>alert("' . $error_msg . '")</script>';
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../inc/dbconn.inc.php";

$user_id = $_SESSION['userid'];
$result = mysqli_query($conn, "SELECT username, email, address, license, dob, user_type FROM users WHERE id = $user_id");
$row = mysqli_fetch_assoc($result);
$name = $row['username'];
$email = $row['email'];
$address = $row['address'];
$license = $row['license'];
$dob = $row['dob'];
$user_type = $row['user_type'];

if ($user_type == 'instructor') {
    $result = mysqli_query($conn, "SELECT company, company_address, phone, price FROM instructors WHERE user_id = $user_id");
    $row = mysqli_fetch_assoc($result);

    $company = $row['company'];
    $company_address = $row['company_address'];
    $phone = $row['phone'];
    $price = $row['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alistair Macvicar">
    <title>TLDR</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../scripts/profileScript.js" defer></script>
</head>
<body>
    <div id="banner">Your profile</div>
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <form id="editForm" action="update-profile.php" method="post">
        <!-- Name (can't edit) -->
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>

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
        <p><strong>License:</strong> <?php echo htmlspecialchars($license); ?></p>

        <!-- Date of Birth (can't edit) -->
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($dob); ?></p>

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
        
        <?php endif; ?>
        
        <input type="submit" value="Update">
        </form>
        <button id="editButton">Edit Profile</button>
    </div>
</body>
</html>

