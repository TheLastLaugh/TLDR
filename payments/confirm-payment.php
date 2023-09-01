<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}

require_once "../inc/dbconn.inc.php";

$bookingId = $_GET['booking_id'];

// Fetch booking details for the invoice
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
    b.id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $bookingId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$bookingDetails = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <link rel="stylesheet" href="../styles/payments-styles.css"/>
</head>
<body>
    <div id="banner">Payments</div>
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div class="confirm" id="confirm">
        <h1>Payment Confirmation</h1>
        <p>Thank you for your payment!</p>

        <h2>Booking Details:</h2>
        <p>Instructor: <?php echo $bookingDetails['instructor_name']; ?></p>
        <p>Date: <?php echo $bookingDetails['booking_date']; ?></p>
        <p>Lesson Price: $<?php echo $bookingDetails['lesson_price']; ?></p>

        <a href="generate-invoice.php?booking_id=<?php echo $bookingId; ?>">View Invoice</a>
        <a href="../dashboard/welcome.php">Go to Home</a>
    </div>
</body>
</html>
