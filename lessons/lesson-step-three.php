<?php
// Initialise the session
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}
// If the user isn't a learner, don't give them access to this page
else if ($_SESSION['user_type'] != 'learner') {
    header("Location: ../dashboard/welcome.php");
    exit;
}

// Uses the database connection file
require_once "../inc/dbconn.inc.php"; 

// Get the id of the learner
$learnerId = $_SESSION['userid'];

// Get the unit id from the form submission
$selectedUnit = isset($_POST['unit'])  ? $_POST['unit'] : null;
$result = mysqli_query($conn, "SELECT unit_name FROM lessons WHERE id = $selectedUnit");
$row = mysqli_fetch_assoc($result);
$unitName = $row['unit_name'];

// Get the instructor id from the form submission
$selectedInstructor = isset($_POST['instructor']) ? $_POST['instructor'] : null;
$result = mysqli_query($conn, "SELECT username FROM users WHERE id = $selectedInstructor");
$row = mysqli_fetch_assoc($result);
$instructorName = $row['username'];
?>

<!-------------------------------------------------------------------------------------------------------------------
 * Simple form with drop-down menu, can add anything you want in here to style the page
--------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book A Lesson</title>
    <link rel="stylesheet" href="../styles/lesson-bookings-styles.css"/>
    <script src="../scripts/bookingScript.js"></script>
</head>
<body>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div id = "content">
        <!-- Step 2: Select lesson -->
        <form action="booking-confirmation.php" method="POST">
                <?php echo 
                        '<input type="hidden" name="unit" value="' . $selectedUnit . '">' .
                        '<input type="hidden" name="instructor" value="' . $selectedInstructor . '">' .
                        '<h1>
                            Select Time and Date for your ' . $unitName . ' lesson with ' . $instructorName .
                        '</h1>';  // This is just to show the user what they selected, can be styled later 
                ?>
                <label for="availability">Select Time and Date:</label>
                <select name="availability" id="time">
                    <?php
                        // Get all the available bookings for the selected instructor from the database and display them in a drop-down menu
                        $sql = "SELECT id, start_time, end_time FROM availability WHERE instructor_id = ? AND is_booked = 0"; // is_booked = 0 means it's available. We set this to 1 when we make the booking so that we don't see it again
                        $statement = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($statement, $sql);
                        mysqli_stmt_bind_param($statement, "i", $selectedInstructor);
                        mysqli_stmt_execute($statement);
                        $result = mysqli_stmt_get_result($statement);

                        while ($row = mysqli_fetch_assoc($result)) {
                            // Display the option in the drop-down menu
                            // FORMAT= <start_time> - <end_time>
                            echo '<option value="' . $row['id'] . '" ' . $selectedText . '>'
                                    . $row['start_time'] . ' - ' . $row['end_time'] .
                                '</option>';
                        }   
                    ?>
                </select>
            <input type="submit" id="timeButton" value="Confirm booking" name="confirm"></input>
        </form>
    </div>
   
</body>
</html>