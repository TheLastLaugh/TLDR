<?php
// Uses the database connection file
require_once "../inc/dbconn.inc.php"; 

// Dummy value for now, Can set this to be the id of the learner using the system later, I just have this as I only made 1 learner account
$learnerId = isset($_POST['learner_id']) ? $_POST['learner_id'] : 1;
$result = mysqli_query($conn, "SELECT username FROM users WHERE id = $learnerId");
$row = mysqli_fetch_assoc($result);
$learnerName = $row['username'];
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
    <title>Book A Lesson</title>
    <link rel="stylesheet" href="../styles/lesson-bookings-styles.css"/>
    <script src="../scripts/bookingScript.js"></script>
</head>
<body>
    <div id="banner">Lessons</div>
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <?php
        echo '<h1>
                Hello, ' . $learnerName . '. Select which lesson you would like to book.' .
             '</h1>';
    ?>
    <!-- Step 1: Select lesson -->
    <form action="lesson-step-two.php" method="POST">
        <?php echo '<input type="hidden" name="learner_id" value="' . $learnerId . '">'; ?>
        <label for="unit">Select Lesson (Unit):</label>
        <select name="unit" id="lesson">
            <?php
                // Get all the lessons (as units) from the database and display them in a drop-down menu
                $result = mysqli_query($conn, "SELECT id, unit_name FROM lessons");
                if ($result) { // If the query was successful
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // If the user has already selected a unit, set it as the selected option
                            // This means that when the button is pressed, it doesn't go back to default and the user can see what they selected
                            $selectedText = ($selected_unit == $row['id']) ? "selected" : ""; 

                            // Display the option in the drop-down menu
                            // FORMAT= Unit #<id> - <unit_name>
                            echo '<option value="' . $row['id'] . '" ' . $selectedText . '>'
                                     . $row['unit_name'] . 
                                 '</option>';
                        }
                    }
                }
            ?>
        </select>
        <input type="submit" id="lessonButton" value="Select an Instructor -->"></input>
    </form>
</body>
</html>