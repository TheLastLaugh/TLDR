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
    <link rel="stylesheet" href="../styles/payments-styles.css"/>
</head>
<body>
    <?php
        echo '<h1>
                Hello, ' . $learnerName . '. Select which lesson you would like to pay for.' .
             '</h1>';
    ?>
    <!-- Step 1: Select lesson -->
    <form action="lesson-step-two.php" method="POST">
        <?php echo '<input type="hidden" name="learner_id" value="' . $learnerId . '">'; ?>
        <label for="unit">Select Lesson You Wish To Pay For:</label>
        <select name="unit" id="lesson">
            <?php
                // Get all the lessons from the booking table and display them in a drop-down menu
                $result = mysqli_query($conn, "SELECT 
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
                b.paid = 0 AND b.learner_id = $learnerId;");

            // paid = 0 means it hasn't been paid for yet
                if ($result) { // If the query was successful
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Display the option in the drop-down menu
                            // FORMAT= <instructor_name> on <booking_date> $<lesson_price>
                            echo '<option value="' . '' . '" ' . '>' . 
                                    // $row['instructor_name'] . ' on ' . $row['booking_date'] . ' $' . $row['lesson_price'] .
                                 '</option>';
                        }
                    }
                }
            ?>
        </select>
        <input type="submit" id="lessonButton" value="Continue to payment -->"></input>
    </form>
</body>
</html>