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

?>

<!-- This page shows a list of all the cbta modules and whether a learner has completed them or not -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesson Progress</title>
    <link rel="stylesheet" href="../styles/style.css"/>
    <link rel="stylesheet" href="../styles/lesson-progress-styles.css">
    <script src="../scripts/moduleScript.js" defer></script>
</head>
<body>
    <div id="banner">Lessons</div>
    <!-- Include the menu bar -->
    <?php include_once "../inc/sidebar.inc.php"; ?>
    <div>
        <h1>Module Progress</h1>
        <?php
            $sql = "SELECT unit_number, unit_name, id FROM lessons;";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                // Get the modules for the unit
                $sql = "SELECT * FROM cbta_modules WHERE unit_number = ?";
                $moduleStatement = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($moduleStatement, "i", $row['unit_number']);
                mysqli_stmt_execute($moduleStatement);
                $moduleResult = mysqli_stmt_get_result($moduleStatement);

                // Check if the user has completed the unit
                $sql = "SELECT * FROM completed_lessons WHERE learner_id = ? AND lesson_id = ?";
                $completedStatement = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($completedStatement, "ii", $learnerId, $row['id']);
                mysqli_stmt_execute($completedStatement);
                $completedResult = mysqli_stmt_get_result($completedStatement);

                echo '<h2 id="module_headings" onclick="toggleModules(' . $row['id'] . ')">' . $row['unit_name'] . '</h2>';
                if ($row3 = mysqli_fetch_assoc($completedResult)) {
                    echo '<p>Completed</p>';
                } else {
                    echo '<p>In Progress</p>';
                }
                echo '<div id="modules-' . $row['id'] . '" style="display:none">';
                while ($row2 = mysqli_fetch_assoc($moduleResult)) {
                    echo '<h3>' . $row2['module_number'] . ' ' . $row2['module_name'] . '</h3>';
                    echo '<p>' . $row2['module_description'] . '</p>';
                }
                echo '</div>';
            }
        ?>
    </div>
</body>
</html>