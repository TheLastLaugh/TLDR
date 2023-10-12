<?php
    // Intialise session
    session_start();

    function getUpcomingLessons($user_id, $conn) {
        $result = mysqli_query($conn, "SELECT b.* FROM bookings as b WHERE learner_id = $user_id ORDER BY booking_date, booking_time ASC");
        while($row = mysqli_fetch_assoc($result)){
            echo("<li>On the ". $row["booking_date"]." at " . date('g a',strtotime($row["booking_time"])) . ", you have a booking with " ."</li>");
        }
    }

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
    require "../inc/dbconn.inc.php";

    $enquiryInstructorID = $_GET["instructorID"];

    $sql = "SELECT username as username FROM users WHERE id = ?";
    $statement = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($statement, $sql);
    mysqli_stmt_bind_param($statement,'i', $enquiryInstructorID);
    mysqli_stmt_execute($statement);
    $enquiryInstructorName = mysqli_fetch_row(mysqli_stmt_get_result($statement))[0];

    $enquiryDate = $_GET["date"];
    $enquiryTime = $_GET["time"];
    
?>

<!-- A simple screen to choose between looking at previous lessons or booking a new one -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="Alistair Macvicar + Darcy Foster" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lessons</title>
        <link rel="stylesheet" href="../styles/lesson-bookings-styles.css"/>
    </head>
    <body>
        <!-- include the menu bar -->
        <?php include_once "../inc/sidebar.inc.php"; ?>
        <div id ="content">
            <div class = "boxed">
                <h1>Book Your Lesson! WOWIES</h1>
                <ul id = "booking-details">
                </ul>
                <form action = "booking-confirmation.php" method = "POST">
                    <input type="text" disabled name = "instructor" value="<?php echo($enquiryInstructorName);?>">
                    <input type="text" disabled name = "date" value="<?php echo($enquiryDate);?>">
                    <input type="text" disabled name = "time" value="<?php echo($enquiryTime);?>">
                    <input type="text" name = "pickup_location">
                    <input type="submit" class="lesson-buttons" value = "Finalise Booking">
                </form>
            </div>
        </div>
    </body>
</html>