<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}

// Uses the database connection file
require_once "../inc/dbconn.inc.php"; 
// Get the id of the learner
$learnerId = isset($_POST['learner_id']) ? $_POST['learner_id'] : null;
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
    <div id="banner">Lessons</div>
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <!-- Step 2: Select lesson -->
    <form action="lesson-step-three.php" method="POST">
        <?php echo  '<input type="hidden" name="unit" value="' . $selectedUnit . '">' .
                    '<input type="hidden" name="learner_id" value="' . $learnerId . '">' .
                    '<h1>
                        Select Instructor for your ' . $unitName . ' lesson' .
                    '</h1>';  // This is just to show the user what they selected, can be styled later 
        ?>
        <label for="instructor">Select Instructor:</label>
        <select name="instructor" id="instructor">
            <?php
                // Get all the instructors from the database and display them in a drop-down menu
                // I might have to expand on this to not show instructors that don't have available bookings, but this works for now.
                $sql = "SELECT user_id, username, price FROM instructors";
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
</body>
</html>