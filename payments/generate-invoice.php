<?php
// initialise session
session_start();

// check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}

// add the database connection
require_once "../inc/dbconn.inc.php";

// Get the booking id from the URL
$bookingId = $_GET['booking_id'];

// Fetch booking details for the invoice
// I think we should expand this to only show the invoice if the user's id is on the booking
// Also I made this before I made big changes to the instructors table, so we can include more info in the invoice when we get around to it.
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

<!-- Invoice page for a lesson -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice for Booking #<?php echo $bookingId; ?></title>
    <link rel="stylesheet" href="../styles/invoice-styles.css"/>
</head>
<body>
    <!-- include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div id = content>
        <div class="invoice" id="invoice">
            <h1>Invoice</h1>
            <h2>Booking #<?php echo $bookingId; ?></h2>
            
            <!-- FORMAT: <attribute>: <value> -->
            <section class="invoice-details">
                <p><strong>Instructor:</strong> <?php echo $bookingDetails['instructor_name']; ?></p>
                <p><strong>Date:</strong> <?php echo $bookingDetails['booking_date']; ?></p>
                <p><strong>Lesson Price:</strong> $<?php echo $bookingDetails['lesson_price']; ?></p>
                <hr>
                <p><strong>Total Amount:</strong> $<?php echo $bookingDetails['lesson_price']; ?></p> 
            </section>

            <!-- button to allow a user to print the invoice easily -->
            <a href="javascript:window.print()">Print Invoice</a>
        </div>
    </div>
</body>
</html>
