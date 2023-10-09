<?php
// Initialise session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}

// add the database connection
require_once "../inc/dbconn.inc.php"; 

// Grab necessary data from the POST request
$bookingId = $_POST['booking_id'];
$learnerId = $_SESSION['userid'];
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

if (str_starts_with($bookingId, 'bookings-')) {
    $table = "bookings";
    $bookingId = substr($bookingId,9);

    // Update the booking to paid
    $sql = "UPDATE bookings SET paid = 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $bookingId);
    mysqli_stmt_execute($stmt);

    // Get the lesson id from the booking
    $sql = "SELECT lesson_id FROM bookings WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $bookingId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $lessonId = $row['lesson_id'];

    // Make the lesson completed
    $sql = "INSERT INTO completed_lessons (learner_id, lesson_id, completion_date) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $learnerId, $lessonId, date("Y-m-d"));
    mysqli_stmt_execute($stmt);

} elseif (str_starts_with($bookingId, 'bills-')) {
    $table = "bills";
    $bookingId = substr($bookingId,6);

    // Update the bills to paid
    $sql = "UPDATE bills SET paid = 1, paid_date = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", date('Y-m-d'), $bookingId);
    mysqli_stmt_execute($stmt);

}

// Redirect to confirmation screen
header("Location: confirm-payment.php?booking_id=$bookingId");

// Close the connection and terminate the script
mysqli_close($conn);
exit();
?>
