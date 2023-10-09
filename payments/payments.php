<?php
// initialise session
session_start();

// check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
} 
// if the user isn't a learner, kick them out
else if ($_SESSION['user_type'] !== 'learner') {
    header("Location: ../dashboard/welcome.php");
    exit();
}

// Uses the database connection file
require_once "../inc/dbconn.inc.php"; 

// Get the user's id and name from the session
$learnerId = $_SESSION['userid'];
$learnerName = $_SESSION['username'];

// Get all the lessons from the booking table and display them in a drop-down menu
$result = mysqli_query($conn, "SELECT
    'bookings' AS tablename,
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
    b.paid = 0 AND b.learner_id = $learnerId
UNION
SELECT 'bills' AS tablename, bills.id AS booking_id, bills.issue_date as booking_date, users.username AS instructor_name, ((bills.hourly_rate / 60) * bills.billed_minutes) AS lesson_price
FROM bills
LEFT JOIN users ON bills.instructor_id = users.id
WHERE bills.paid = 0 AND bills.learner_id = $learnerId;");
?>

<!-------------------------------------------------------------------------------------------------------------------
 * Simple form with drop-down menus can add anything you want in here to style the page
--------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay for Lessons</title>
    <link rel="stylesheet" href="../styles/payments-styles.css"/>
</head>
<body>
    <!-- include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div id = "content">
    <?php
        // If the user has no lessons to pay for, display a message
            if (mysqli_num_rows($result) == 0) {
                echo '<h1>
                        Hello, ' . $learnerName . '. You have no lessons to pay for.' .
                    '</h1>';
            } 
            // Otherwise, display the lessons in a drop-down menu
            else {
                echo '<h1>
                        Hello, ' . $learnerName . '. Select which lesson you would like to pay for.' .
                    '</h1>';

                // <!-- Step 1: Select lesson to pay for -->
                echo '<form action="payments-step-two.php" method="POST">'; ?>
                    <label for="unit">Select Lesson You Wish To Pay For:</label>
                    <select name="unit" id="lesson">
                        <?php
                        // paid = 0 means it hasn't been paid for yet
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Display the option in the drop-down menu
                                // FORMAT: <instructor_name> on <booking_date> $<lesson_price>
                                echo '<option value="' . $row['tablename'] . '-' . $row['booking_id']  . '">' . 
                                        $row['instructor_name'] . ' on ' . date("d/m/Y", strtotime($row['booking_date'])) . ' $' . number_format($row['lesson_price'], 2) .
                                    '</option>';
                            } 
                        ?>
                    </select>
                    <input type="submit" id="lessonButton" value="Continue to payment -->"></input>
                </form>
            <?php
            }
        ?>
    </div>
</body>
</html>