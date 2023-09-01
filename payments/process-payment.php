<?php
require_once "../inc/dbconn.inc.php"; 

// Grab necessary data from the POST request
$bookingId = $_POST['booking_id'];
$learnerId = $_POST['learner_id'];
$paymentMethodId = $_POST['payment_method'] ?? null;
$methodName = $_POST['method_name'];
$address = $_POST['address'];
$cardType = $_POST['card_type'];
$cardNumber = $_POST['card_number'];
$expiryMonth = $_POST['expiry_month'];
$expiryYear = $_POST['expiry_year'];
$cvv = $_POST['cvv'];

// Extract the last four digits of the card number
$lastFourDigits = substr($cardNumber, -4);

// Check if this payment method already exists
$sql = "SELECT * FROM payment_methods WHERE card_number = ? AND learner_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $cardNumber, $learnerId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) == 0) {
    // Payment method doesn't exist, so insert it
    $sql = "INSERT INTO payment_methods (learner_id, method_name, address, card_type, card_number, last_four_digits, expiry_month, expiry_year, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssiiiii", $learnerId, $methodName, $address, $cardType, $cardNumber, $lastFourDigits, $expiryMonth, $expiryYear, $cvv);
    mysqli_stmt_execute($stmt);
}

// Update the booking to paid
$sql = "UPDATE bookings SET paid = 1 WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $bookingId);
mysqli_stmt_execute($stmt);

// Redirect to confirmation screen
header("Location: confirm-payment.php?booking_id=$bookingId");
?>
