<?php
// Initialise session
session_start();

// Add the database connection
require_once "../inc/dbconn.inc.php";

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit();
}

// If the user is a learner, don't give them access to this page
// elseif ($_SESSION['user_type'] == 'learner') {
//     header("Location: ../dashboard/welcome.php");
//     exit;
// }

// If the user is a qsd, don't give them access to this page
elseif ($_SESSION['user_type'] == 'qsd') {
    header("Location: ../dashboard/welcome-qsd.php");
    exit;
}

elseif ($_SESSION['user_type'] == 'instructor' || $_SESSION['user_type'] == 'government' || $_SESSION['user_type'] == 'learner') {
    $action = $_POST['action'];
    if (isset($_POST['unit'])) {
        $unit = $_POST['unit'];
    }
    if (isset($_POST['task'])) {
        $task = $_POST['task'];
    }
    if (isset($_POST['message'])) {
        $message = $_POST['message'];
    }
}

function createStudentTask ($conn, $unit, $task) {
    // echo 'createStudentTask';
    // echo $_SESSION["student"]["id"];
    // echo $unit;
    // echo $task;
    $sql = "INSERT INTO student_tasks (student_id, unit, task) VALUES (?, ?, ?);";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $_SESSION["student"]["id"], $unit, $task);
    mysqli_stmt_execute($stmt);
}

function completeTask ($conn, $unit, $task) {
    // echo 'completeTask';
    // echo $_SESSION["userid"];
    // echo $_SESSION["student"]["id"];
    // echo $unit;
    // echo $task;
    $sql = "UPDATE student_tasks SET completed_instructor_id = ?, completed = 1, completed_date = ? WHERE student_id = ? AND unit = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isiii", $_SESSION["userid"], date("Y-m-d"), $_SESSION["student"]["id"], $unit, $task);
    mysqli_stmt_execute($stmt);
}

function incompleteTask ($conn, $unit, $task) {
    // echo 'completeTask';
    // echo $_SESSION["userid"];
    // echo $_SESSION["student"]["id"];
    // echo $unit;
    // echo $task;
    $sql = "UPDATE student_tasks SET completed_instructor_id = null, completed = 0, completed_date = null, student_signature = 0 WHERE student_id = ? AND unit = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $_SESSION["student"]["id"], $unit, $task);
    mysqli_stmt_execute($stmt);
}

function studentFollowup ($conn, $unit, $task) {
    // echo 'studentFollowup';
    // echo $_SESSION["userid"];
    // echo $_SESSION["student"]["id"];
    // echo $unit;
    // echo $task;
    $sql = "UPDATE student_tasks SET student_followup = 1 WHERE student_id = ? AND unit = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $_SESSION["student"]["id"], $unit, $task);
    mysqli_stmt_execute($stmt);
}

function instructorFollowup ($conn, $unit, $task) {
    // echo 'studentFollowup';
    // echo $_SESSION["userid"];
    // echo $_SESSION["student"]["id"];
    // echo $unit;
    // echo $task;
    $sql = "UPDATE student_tasks SET instructor_followup = 1 WHERE student_id = ? AND unit = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $_SESSION["student"]["id"], $unit, $task);
    mysqli_stmt_execute($stmt);
}

function updateComment ($conn, $unit, $task, $comment) {
    $sql = "UPDATE student_tasks SET instructor_notes = ? WHERE student_id = ? AND unit = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "siii", $comment, $_SESSION["student"]["id"], $unit, $task);
    mysqli_stmt_execute($stmt);
}

function countThings ($conn, $unit, $count_type) {

    $count = 0;

    if ($count_type == 'completed') {
        $sql = "SELECT COUNT(*) FROM student_tasks WHERE student_id = ? AND unit = ? AND completed = 1 AND student_signature = 1;";
        $stmt = mysqli_prepare($conn, $sql);
        if ($_SESSION["user_type"] == 'instructor' || $_SESSION["user_type"] == 'government') {
            mysqli_stmt_bind_param($stmt, "ii", $_SESSION["student"]["id"], $unit);
        } else {
            // must be a student
            mysqli_stmt_bind_param($stmt, "ii", $_SESSION["userid"], $unit);
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ( mysqli_num_rows($result) >= 1 ) {
            if ($row = $result -> fetch_assoc()) {
                $count = $row['COUNT(*)'];
            }
        } 
    } elseif ($count_type == 'unsigned') {
        $sql = "SELECT COUNT(*) FROM student_tasks WHERE student_id = ? AND unit = ? AND completed = 1 AND (student_signature = 0 OR student_signature IS NULL);";
        $stmt = mysqli_prepare($conn, $sql);
        if ($_SESSION["user_type"] == 'instructor' || $_SESSION["user_type"] == 'government') {
            mysqli_stmt_bind_param($stmt, "ii", $_SESSION["student"]["id"], $unit);
        } else {
            // must be a student
            mysqli_stmt_bind_param($stmt, "ii", $_SESSION["userid"], $unit);
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ( mysqli_num_rows($result) >= 1 ) {
            if ($row = $result -> fetch_assoc()) {
                $count = $row['COUNT(*)'];
            }
        } 
    } elseif ($count_type == 'student-followup') {
        $sql = "SELECT COUNT(*) FROM student_tasks WHERE student_id = ? AND unit = ? AND student_followup = 1 AND (completed = 0 OR completed is NULL);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION["userid"], $unit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ( mysqli_num_rows($result) >= 1 ) {
            if ($row = $result -> fetch_assoc()) {
                $count = $row['COUNT(*)'];
            }
        } 
    } elseif ($count_type == 'instructor-followup') {
        $sql = "SELECT COUNT(*) FROM student_tasks WHERE student_id = ? AND unit = ? and instructor_followup = 1 AND (completed = 0 OR completed is NULL);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION["student"]["id"], $unit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ( mysqli_num_rows($result) >= 1 ) {
            if ($row = $result -> fetch_assoc()) {
                $count = $row['COUNT(*)'];
            }
        } 
    }

    return $count;

}

function getTaskStatuses($conn, $unit) {

    if ($_SESSION["user_type"] == 'government') {
        $sql = "SELECT task, completed, completed_date, student_followup, instructor_followup, student_signature FROM student_tasks WHERE student_id = ? AND unit = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION["student"]["id"], $unit);
    } elseif ($_SESSION["user_type"] == 'instructor') {
        $sql = "SELECT task, completed, completed_date, instructor_followup, student_signature FROM student_tasks WHERE student_id = ? AND unit = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION["student"]["id"], $unit);
    } else {
        // must be a student
        $sql = "SELECT task, completed, completed_date, student_followup, student_signature FROM student_tasks WHERE student_id = ? AND unit = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION["userid"], $unit);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $data = array();

    if ( mysqli_num_rows($result) >= 1 ) {
        while ($row = $result -> fetch_assoc()) {
            $row['user-type'] = $_SESSION['user_type'];
            array_push($data, $row);
        }
    } 

    return $data;

}

if ($action == 'complete-task') {

    $sql = "SELECT COUNT(*) FROM student_tasks WHERE student_id = ? AND unit = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $_SESSION["student"]["id"], $unit, $task);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ( mysqli_num_rows($result) >= 1 ) {

        if ($row = $result -> fetch_assoc()) {

            if ($row['COUNT(*)'] >= 1) {

                completeTask($conn, $unit, $task);

            } else {
                
                createStudentTask($conn, $unit, $task);
                completeTask($conn, $unit, $task);

            }


        }
    }

} elseif ($action == 'incomplete-task') {

    $sql = "SELECT COUNT(*) FROM student_tasks WHERE student_id = ? AND unit = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $_SESSION["student"]["id"], $unit, $task);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ( mysqli_num_rows($result) >= 1 ) {

        if ($row = $result -> fetch_assoc()) {

            if ($row['COUNT(*)'] >= 1) {

                incompleteTask($conn, $unit, $task);

            } else {
                
                createStudentTask($conn, $unit, $task);
                incompleteTask($conn, $unit, $task);

            }


        }
    }

} elseif ($action == 'student_followup') {

    $sql = "SELECT COUNT(*) FROM student_tasks WHERE student_id = ? AND unit = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $_SESSION["student"]["id"], $unit, $task);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ( mysqli_num_rows($result) >= 1 ) {

        if ($row = $result -> fetch_assoc()) {

            if ($row['COUNT(*)'] >= 1) {

                studentFollowup($conn, $unit, $task);

            } else {
                
                createStudentTask($conn, $unit, $task);
                studentFollowup($conn, $unit, $task);

            }

        }
    }

} elseif ($action == 'instructor_followup') {

    $sql = "SELECT COUNT(*) FROM student_tasks WHERE student_id = ? AND unit = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $_SESSION["student"]["id"], $unit, $task);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ( mysqli_num_rows($result) >= 1 ) {

        if ($row = $result -> fetch_assoc()) {

            if ($row['COUNT(*)'] >= 1) {

                instructorFollowup($conn, $unit, $task);

            } else {
                
                createStudentTask($conn, $unit, $task);
                instructorFollowup($conn, $unit, $task);

            }

        }
    }

} elseif ($action == 'snapshot') {

    $data = array();
    $totals = array(8, 6, 8, 8, 1, 1); //total tasks per unit
    $alltasks = 32; //total tasks of all units

    for ($x = 0; $x <= 5; $x++) {
        $myObj['unit'] = $x + 1;
        $myObj['total'] = $totals[$x];
        $myObj['completed'] = countThings($conn, $x+1, 'completed');
        $myObj['unsigned'] = countThings($conn, $x+1, 'unsigned');
        if ($_SESSION["user_type"] == 'learner') {
            $myObj['follow_up'] = countThings($conn, $x + 1, 'student-followup');
        }
        elseif ($_SESSION["user_type"] == 'instructor') {
            $myObj['follow_up'] = countThings($conn, $x + 1, 'instructor-followup');
        }
        else {
            $myObj['follow_up'] = 0;
        }
        $myObj['incomplete'] = $myObj['total']-$myObj['completed']-$myObj['unsigned']-$myObj['follow_up'];
        $myObj['tasks'] = getTaskStatuses($conn, $x+1);
        array_push($data, $myObj);
    } 

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);

} elseif ($action == 'get-task') {

    $sql = "SELECT student_tasks.student_id, student_tasks.student_signature, student_tasks.unit, student_tasks.task, student_tasks.completed, student_tasks.instructor_notes, student_tasks.completed_date, student_tasks.completed_instructor_id, students.username as student_name, students.license as student_license, instructors.username as instructor_name, instructors.license as instructor_license
    FROM student_tasks 
    LEFT JOIN users AS students ON student_tasks.student_id = students.id
    LEFT JOIN users AS instructors ON student_tasks.completed_instructor_id = instructors.id
    WHERE student_id = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    if ($_SESSION["user_type"] == 'instructor' || $_SESSION["user_type"] == 'government') {
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION["student"]["id"], $task);
    } else {
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION["userid"], $task);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $returnData = null;
    $returnData['usertype'] = $_SESSION['user_type'];

    if ( mysqli_num_rows($result) >= 1 ) {
        if ($row = $result -> fetch_assoc()) {
            $returnData['task'] = $row;
        }
    } else {
        $returnData['task'] = json_decode ("{}");
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($returnData);

} elseif ($action == 'update-comment') {

    $sql = "SELECT COUNT(*) FROM student_tasks WHERE student_id = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $_SESSION["student"]["id"], $task);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ( mysqli_num_rows($result) >= 1 ) {

        if ($row = $result -> fetch_assoc()) {

            if ($row['COUNT(*)'] >= 1) {

                updateComment($conn, $unit, $task, $message);

            } else {
                
                createStudentTask($conn, $unit, $task);
                updateComment($conn, $unit, $task, $message);

            }

        }
    }

} elseif ($action == 'sign' && $_SESSION['user_type'] == 'learner') {

    $sql = "UPDATE student_tasks SET student_signature = 1 WHERE student_id = ? AND task = ?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $_SESSION["userid"], $task);
    mysqli_stmt_execute($stmt);

}

// Close the connection and terminate the script.
mysqli_close($conn);
exit();

?>