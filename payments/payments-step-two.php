<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}

require_once "../inc/dbconn.inc.php"; 

// Grab the booking ID and learner ID
$bookingId = $_POST['unit'];
$learnerId = $_POST['learner_id'];

// Get details of the selected lesson
$sql = "SELECT 
    b.id AS booking_id, 
    b.booking_date,
    i.username AS instructor_name,
    i.price AS lesson_price
FROM 
    bookings AS b
JOIN 
    availability AS a ON b.availability_id = a.id
JOIN 
    instructors AS i ON a.instructor_id = i.user_id
WHERE 
    b.id = $bookingId;";

$lessonResult = mysqli_query($conn, $sql);
$lessonDetails = mysqli_fetch_assoc($lessonResult);

// Get existing payment methods for this user
$paymentMethods = mysqli_query($conn, "SELECT * FROM payment_methods WHERE learner_id = $learnerId");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book A Lesson</title>
    <link rel="stylesheet" href="../styles/payments-styles.css"/>
    <script src="../scripts/paymentScript.js" defer></script>
</head>
<body>
    <div id="banner">Payments</div>
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <h1>Payment for <?php echo $lessonDetails['instructor_name'] . ' on ' . $lessonDetails['booking_date']; ?></h1>
    <h1>Lesson Price: $<?php echo $lessonDetails['lesson_price']; ?></h1>
    
    <!-- Display existing payment methods -->
    <form action="process-payment.php" method="POST">
        <h2>Select a payment method:</h2>
        <?php
            if (mysqli_num_rows($paymentMethods) > 0) {
                echo '<select id="paymentMethodsDropdown">';
                echo '<option value="0">Select a payment method</option>';
                while ($method = mysqli_fetch_assoc($paymentMethods)) {
                    echo '<option name="payment_method" value="' . $method['id'] . '" data-method_name="' . $method['method_name'] . '" data-address="' . $method['address'] . '" data-card_type="' . $method['card_type'] . '" data-card_number="' . $method['card_number'] . '">' . $method['method_name'] . ' (' . $method['last_four_digits'] . ')</option>';
                }
                echo '</select>';
            } else {
                echo '<p>No payment methods found. Please add one.</p>';
            }
        ?>
        <input type="button" value="Add a new payment method" id="togglePaymentForm">
        
        <!-- Add a new payment method (Hidden if there are saved payment methods)-->
        <div id="paymentForm" style="display:none">
            <h2>Add a new payment method:</h2>

            <label for="method_name">Name on Card:</label>
            <input type="text" name="method_name" required>

            <label for="address">Address:</label>
            <input type="text" name="address" required>

            <label for="card_type">Select Card Type:</label>
            <select name="card_type">
                <option value="visa">Visa</option>
                <option value="mastercard">Mastercard</option>
            </select>

            <label for="card_number">Card Number:</label>
            <input type="text" name="card_number" minlength="16" maxlength="16" pattern="\d{16}" required>

            <!-- More fields for expiry, CVV, etc. -->
            <label for="expiry_month">Expiry Month:</label>
            <select name="expiry_month">
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
            </select>

            <label for="expiry_year">Expiry Year:</label>
            <select name="expiry_year">
                <?php
                for ($i = 2023; $i <= 2030; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
            </select>

            <label for="cvv">CVV:</label>
            <input type="text" name="cvv" minlength="3" maxlength="3" pattern="\d{3}" required> 
            
            <!-- Hidden fields for data -->
            <input type="hidden" name="learner_id" value="<?php echo $learnerId; ?>">
            <input type="hidden" name="booking_id" value="<?php echo $bookingId; ?>">
        </div>
        
        <input type="submit" value="Confirm Payment">
    </form>
</body>
</html>
