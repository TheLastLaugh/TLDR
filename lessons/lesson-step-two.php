<?php
// Initialize the session
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
        <form action="lesson-step-three.php" method="POST">
            <?php echo  '<input type="hidden" name="unit" value="' . $selectedUnit . '">' .
                        '<h1>
                            Select Instructor for your ' . $unitName . ' lesson' .
                        '</h1>';  // This is just to show the user what they selected, can be styled later 
            ?>
            <label for="instructor">Select Instructor:</label>
            <select name="instructor" id="instructor">
                <?php
                    // Get all the instructors from the database and display them in a drop-down menu
                    // doesn't show instructors that don't have available bookings
                    $sql = "SELECT i.user_id, i.username, i.price
                    FROM instructors i
                    WHERE EXISTS (
                        SELECT 1
                        FROM availability a
                        WHERE a.instructor_id = i.user_id AND a.is_booked = 0
                    )
                    ";
                    $statement = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($statement, $sql);
                    mysqli_stmt_execute($statement);
                    $result = mysqli_stmt_get_result($statement);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Display the option in the drop-down menu
                        // FORMAT= Instructor #<id> - Price: $<price>
                        echo '<option value="' . $row['user_id'] . '">'
                                . $row['username'] . ' - Price: $' . $row['price'] . 
                            '</option>';
                    }
                ?>
            </select>

            <input type="submit" id="instructorButton" value="Choose a Time -->"></input>
        </form>
    </div>
</body>
</html>