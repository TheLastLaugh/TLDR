<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}

require_once "../inc/dbconn.inc.php"; 

// Grab the booking ID and learner ID
$bookingId = $_POST['unit'];
$learnerId = $_SESSION['userid'];

// Get details of the selected lesson
if (str_starts_with($bookingId, 'bookings-')) {
    $table = "bookings";
    $bookingId = substr($bookingId,9);
    $sql = "SELECT 
        b.booking_id AS booking_id, 
        b.booking_date,
        i.username AS instructor_name,
        i.price AS lesson_price
    FROM 
        bookings AS b
    JOIN 
        instructors AS i ON b.instructor_id = i.user_id
    WHERE 
        booking_id = $bookingId;";

    $lessonResult = mysqli_query($conn, $sql);
    $lessonDetails = mysqli_fetch_assoc($lessonResult);
} elseif (str_starts_with($bookingId, 'bills-')) {
    $table = "bills";
    $bookingId = substr($bookingId,6);
    $sql = "SELECT bills.id AS booking_id, bills.issue_date as booking_date, users.username AS instructor_name, ((bills.hourly_rate / 60) * bills.billed_minutes) AS lesson_price
    FROM bills
    LEFT JOIN users ON bills.instructor_id = users.id
    WHERE bills.id = $bookingId;";
    $lessonResult = mysqli_query($conn, $sql);
    $lessonDetails = mysqli_fetch_assoc($lessonResult);
}

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
    <title>Payments</title>
    <link rel="stylesheet" href="../styles/payments-styles.css"/>
    <script src="../scripts/paymentScript.js" defer></script>
</head>
<body>
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div id = "content">
        <h1>Payment for <?php echo $lessonDetails['instructor_name'] . ' on ' . date("d/m/Y", strtotime($lessonDetails['booking_date'])); ?></h1>
        <h1>Lesson Price: $<?php echo number_format($lessonDetails['lesson_price'], 2); ?></h1>
        
        <!-- Display existing payment methods -->
        <form action="process-payment.php" method="POST">
            <h2>Select a payment method:</h2>
            <?php
                if (mysqli_num_rows($paymentMethods) > 0) {
                    echo '<select id="paymentMethodsDropdown">';
                    echo '<option value="0">Select a payment method</option>';
                    // FORMAT: <method_name> (<last_four_digits>)
                    while ($method = mysqli_fetch_assoc($paymentMethods)) {
                        echo '<option name="payment_method" value="' . $method['id'] . '" data-method_name="' . $method['method_name'] . '" data-address="' . $method['address'] . '" data-card_type="' . $method['card_type'] . '" data-card_number="' . $method['card_number'] . '">' . $method['method_name'] . ' (' . $method['last_four_digits'] . ')</option>';
                    }
                    echo '</select>';
                } 
                // If the user doesn't have any saved payment methods they're forced to add one
                else {
                    echo '<p>No payment methods found. Please add one.</p>';
                }
            ?>
            <!-- If they press this button the below form gets shown -->
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
                <input type="text" name="card_number" minlength="16" maxlength="16" pattern="\d{16}" id="creditCardInput" required>
                
                <!-- Makes a drop down menu for 1-12 -->
                <label for="expiry_month">Expiry Month:</label>
                <select name="expiry_month">
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    ?>
                </select>
                
                <!-- Makes a drop-down menu until 2030 -->
                <label for="expiry_year">Expiry Year:</label>
                <select name="expiry_year">
                    <?php
                    for ($i = 2023; $i <= 2030; $i++) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    ?>
                </select>
                
                <!-- Hidden fields for data -->
                <input type="hidden" name="booking_id" value="<?php echo $table . '-' . $bookingId; ?>">
            </div>
            <div id="cvvBox" style="display: none">
                    <label for="cvv">CVV:</label>
                    <input type="text" name="cvv" minlength="3" maxlength="3" pattern="\d{3}" required> 
            </div>
            
            <input type="submit" value="Confirm Payment">
        </form>
    </div>
</body>
</html>
