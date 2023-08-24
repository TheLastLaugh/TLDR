<?php
// Uses the database connection file
require_once "../inc/dbconn.inc.php"; 

// Dummy value for now, Can set this to be the id of the learner using the system later, I just have this as I only made 1 learner account
$learner_id = 1;  

/*--------------------------------------------------------------------------------------------------------------------
 * These need to be at the top, since the form redirects to this page I re-use the same page to display the next form. 
 * The first load will default to null but after that we start cooking
 --------------------------------------------------------------------------------------------------------------------*/
// Get the unit id from the form submission
$selected_unit = isset($_POST['unit'])  ? $_POST['unit'] : null;
// Get the instructor id from the form submission
$selected_instructor = isset($_POST['instructor']) ? $_POST['instructor'] : null;
// Get the availability id from the form submission
$selected_availability = isset($_POST['availability']) ? $_POST['availability'] : null;


//This happens after the user clicks the confirm button after selecting all values. Relevant code for this is at the bottom of the page
if (isset($_POST['confirm'])) {
    // Insert the booking into the database
    $sql = "INSERT INTO bookings (learner_id, availability_id, booking_date) VALUES (?, ?, NOW())";
    $statement = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($statement, $sql);
    mysqli_stmt_bind_param($statement, "ii", $learner_id, $selected_availability); // 2 integers
    mysqli_stmt_execute($statement);

    // Peace of mind. Can echo this into a div or something and style it later, or redirect to another page. We'll figure it out
    echo "Lesson booked successfully!"; 
    
    // Sets the availability of the instructor to booked so it doesn't show up in the list of available times. This is unique for each Instructor.
    $sqlUpdate = "UPDATE availability SET is_booked = 1 WHERE id = ?";
    $statementUpdate = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($statementUpdate, $sqlUpdate);
    mysqli_stmt_bind_param($statementUpdate, "i", $selected_availability); // 1 integer
    mysqli_stmt_execute($statementUpdate);
}

?>

<!-------------------------------------------------------------------------------------------------------------------
 * Simple form with drop-down menus, can add anything you want in here to style the page, 
 * just remember that more stuff gets added in the php later, so you can tag them to style as well. 
--------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book A Lesson</title>
    <link rel="stylesheet" href="../styles/style.css"/>
</head>
<body>
    <!-- Step 1: Select lesson -->
    <form action="lesson-bookings.php" method="POST">
        <label for="unit">Select Lesson (Unit):</label>
        <select name="unit">
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
        <button type="submit">Next</button>
    </form>
</body>
</html>

<!-- Step 2: Select instructor -->
<?php
if ($selected_unit) { // If the user has selected a lesson (unit)
    // Display the form to select an instructor - Same as the first form, just with different values
    echo '<form action="lesson-bookings.php" method="post">
            <input type="hidden" name="unit" value="' . $selected_unit . '">
            <label for="instructor">
                Select Instructor:
            </label>
            <select name="instructor">';
    
    // Get all the instructors that teach the selected lesson (unit) from the database and display them in a drop-down menu
    // I might have to expand on this to not show instructors that don't have available bookings, but this works for now.
    $sql = "SELECT user_id, price FROM instructors WHERE lesson_id = ?";
    $statement = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($statement, $sql);
    mysqli_stmt_bind_param($statement, "i", $selected_unit);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    while ($row = mysqli_fetch_assoc($result)) {
        // If the user has already selected an instructor, set it as the selected option
        // This means that when the button is pressed, it doesn't go back to default and the user can see what they selected
        $selectedText = ($selected_instructor == $row['user_id']) ? "selected" : ""; 

        // Display the option in the drop-down menu
        // FORMAT= Instructor #<id> - Price: $<price>
        echo '<option value="' . $row['user_id'] . '" ' . $selectedText . '>
                Instructor #' . $row['user_id'] . ' - Price: $' . $row['price'] . 
             '</option>';
    }    
    echo '  </select>
            <button type="submit">Next</button>
          </form>';
}
//<-- Step 3: Select date & time -->
if ($selected_instructor && $selected_unit) { // If the user has selected an instructor and a lesson (unit)
    // Display the form to select a date & time - Same as the other forms, just with different values
    echo '<form action="lesson-bookings.php" method="post">
            <input type="hidden" name="unit" value="' . $selected_unit . '">
            <input type="hidden" name="instructor" value="' . $selected_instructor . '">
            <label for="availability">Select Date & Time:</label>
            <select name="availability">';
    
    // Get all the available bookings for the selected instructor from the database and display them in a drop-down menu
    $sql = "SELECT id, start_time, end_time FROM availability WHERE instructor_id = ? AND is_booked = 0"; // is_booked = 0 means it's available. We set this to 1 when we make the booking so that we don't see it again
    $statement = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($statement, $sql);
    mysqli_stmt_bind_param($statement, "i", $selected_instructor);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    while ($row = mysqli_fetch_assoc($result)) {
        // If the user has already selected a booking, set it as the selected option
        // This means that when the button is pressed, it doesn't go back to default and the user can see what they selected
        $selectedText = ($selected_availability == $row['id']) ? "selected" : "";

        // Display the option in the drop-down menu
        // FORMAT= <start_time> - <end_time>
        echo '<option value="' . $row['id'] . '" ' . $selectedText . '>'
                . $row['start_time'] . ' - ' . $row['end_time'] .
             '</option>';
    }    
    echo '  </select>
            <button type="submit" name="confirm">
                Confirm Booking
            </button>
          </form>';
}
?>