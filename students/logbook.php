<?php
// Initialise session
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}

// Add the database connection
require_once "../inc/dbconn.inc.php"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Jordan Prime" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook</title>
    <link rel="stylesheet" href="../styles/logbook-view.css"/>
    <script type="text/javascript" src="./logbook.js" defer></script>
</head>
<body>
    <?php include_once "../inc/sidebar.inc.php"; ?>
        <div id='content'>
            <?php 
                if (($_SESSION['user_type'] == 'instructor' || $_SESSION['user_type'] == 'government' || $_SESSION['user_type'] == 'qsd') && isset($_SESSION['student']['username'])) {
                    echo "<p>Student Name: {$_SESSION['student']['username']}</p>";
                    echo "<a href='../search/search.php?usertype=student'>Change Student</a><br>";
                    echo '<a href="../logbooks/logbook-entry.php">Add a new logbook entry</a><br><br>';
                } 
            ?>

            <div class="logbook-tabs" id="logbook-tabs">
                <button class="tablinks" onclick="openTab(event, 'Pending')" id="pending-button">Unsigned</button>
                <button class="tablinks" onclick="openTab(event, 'Detailed')" id="detailed-button">All</button>
                <button class="tablinks" onclick="openTab(event, 'Day')" id="day-button">Day</button>
                <button class="tablinks" onclick="openTab(event, 'Night')" id="night-button">Night</button>
                <button class="tablinks" onclick="openTab(event, 'Summary')" id="summary-button">Summary</button>
            </div>

            <div id="Pending" class="tabcontent">

                <table>
                    <tr>
                        <th rowspan='2'>Date</th>
                        <th colspan='3'>Time</th>
                        <th colspan='2'>Location (Suburb)</th>
                        <th colspan='3'>Conditions</th>
                        <th rowspan='2'>Learners Signature</th>
                        <th colspan='3'>Qualified Supervising Driver</th>
                    </tr>
                    <tr>
                        <th>Start am/pm</th>
                        <th>Finish am/pm</th>
                        <th>Duration (Minutes)</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Road</th>
                        <th>Weather</th>
                        <th>Traffic</th>
                        <th>Full Name</th>
                        <th>Licence No.</th>
                        <th>Signature</th>
                    </tr>
                    <?php

                        $sql = "SELECT logbooks.id, `learner_id`, `qsd_id`, `date`, `start_time`, `end_time`, `duration`, `start_location`, `end_location`, `road_type`, `weather`, `traffic`, `qsd_name`, `qsd_license`, `confirmed`, `time_of_day`, users.id as userid, users.username, users.license FROM `logbooks` LEFT JOIN users ON logbooks.qsd_id = users.id WHERE learner_id = ? AND confirmed = 0 ORDER BY date DESC, start_time DESC;";
                        $stmt = mysqli_prepare($conn, $sql);
                        if ($_SESSION['user_type'] == 'learner') {
                            mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        } else {
                            mysqli_stmt_bind_param($stmt, "i", $_SESSION['student']["id"]);
                        }
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ( mysqli_num_rows($result) >= 1 ) {
                            while ($row = $result -> fetch_assoc()) {
                                echo "<tr>";
                                // <td>2023-09-01</td>
                                $date0 = date("d/m/Y", strtotime($row['date']));
                                echo "<td>$date0</td>";
                                // <td>08:30 AM</td>
                                $date = "{$row['date']} {$row['start_time']}";
                                $date = date("g:i A", strtotime($date));
                                echo "<td>{$date}</td>";
                                // <td>09:30 AM</td>
                                $date2 = "{$row['date']} {$row['end_time']}";
                                $date2 = date("g:i A", strtotime($date2));
                                echo "<td>{$date2}</td>";
                                // <td>60</td>
                                echo "<td>{$row['duration']}</td>";
                                // <td>Blackwood</td>
                                echo "<td>{$row['start_location']}</td>";
                                // <td>Marion</td>
                                echo "<td>{$row['end_location']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['road_type']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['weather']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['traffic']}</td>";
                                // <td>Signed</td>
                                if ($_SESSION['user_type'] == 'learner') {
                                    // echo "<td><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    // <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                    // </svg> Signed</td>";
                                    // $id = $row['id'];
                                    echo "<td><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                    </svg> Signature Required: <a href='#' onclick='signTask({$row['id']})'>Click here to sign</a></td>";
                                } else {
                                    echo "<td>Not Signed</td>";
                                }
                                // <td>Kathryn Laneway</td>
                                echo "<td>{$row['username']}</td>";
                                // <td>KL1234</td>
                                echo "<td>{$row['license']}</td>";
                                // <td>Signed</td>
                                echo "<td><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                </svg> Signed</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>
                                <td colspan='13'>No entries.</td>
                            </tr>";

                        }

                    ?>
                </table>

            </div>

            <div id="Detailed" class="tabcontent">

                <table>
                    <tr>
                        <th rowspan='2'>Date</th>
                        <th colspan='3'>Time</th>
                        <th colspan='2'>Location (Suburb)</th>
                        <th colspan='3'>Conditions</th>
                        <th rowspan='2'>Learners Signature</th>
                        <th colspan='3'>Qualified Supervising Driver</th>
                    </tr>
                    <tr>
                        <th>Start am/pm</th>
                        <th>Finish am/pm</th>
                        <th>Duration (Minutes)</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Road</th>
                        <th>Weather</th>
                        <th>Traffic</th>
                        <th>Full Name</th>
                        <th>Licence No.</th>
                        <th>Signature</th>
                    </tr>
                    <?php

                        $sql = "SELECT * FROM logbooks LEFT JOIN users ON logbooks.qsd_id = users.id WHERE learner_id = ? AND confirmed = 1 ORDER BY date DESC, start_time DESC;";
                        $stmt = mysqli_prepare($conn, $sql);
                        if ($_SESSION['user_type'] == 'learner') {
                            mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        } else {
                            mysqli_stmt_bind_param($stmt, "i", $_SESSION['student']["id"]);
                        }
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ( mysqli_num_rows($result) >= 1 ) {
                            while ($row = $result -> fetch_assoc()) {
                                echo "<tr>";
                                // <td>2023-09-01</td>
                                $date0 = date("d/m/Y", strtotime($row['date']));
                                echo "<td>$date0</td>";
                                // <td>08:30 AM</td>
                                $date = "{$row['date']} {$row['start_time']}";
                                $date = date("g:i A", strtotime($date));
                                echo "<td>{$date}</td>";
                                // <td>09:30 AM</td>
                                $date2 = "{$row['date']} {$row['end_time']}";
                                $date2 = date("g:i A", strtotime($date2));
                                echo "<td>{$date2}</td>";
                                // <td>60</td>
                                echo "<td>{$row['duration']}</td>";
                                // <td>Blackwood</td>
                                echo "<td>{$row['start_location']}</td>";
                                // <td>Marion</td>
                                echo "<td>{$row['end_location']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['road_type']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['weather']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['traffic']}</td>";
                                // <td>Signed</td>
                                if ($row['confirmed'] == 1) {
                                    echo "<td><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                    </svg> Signed</td>";
                                } else {
                                    echo "<td>Click here to sign</td>";
                                }
                                // <td>Kathryn Laneway</td>
                                echo "<td>{$row['username']}</td>";
                                // <td>KL1234</td>
                                echo "<td>{$row['license']}</td>";
                                // <td>Signed</td>
                                echo "<td><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                </svg> Signed</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>
                                <td colspan='13'>No entries.</td>
                            </tr>";

                        }
                    ?>
                </table>
            </div>

            <div id="Day" class="tabcontent">

                <table>
                    <tr>
                        <th rowspan='2'>Date</th>
                        <th colspan='3'>Time</th>
                        <th colspan='2'>Location (Suburb)</th>
                        <th colspan='3'>Conditions</th>
                        <th rowspan='2'>Learners Signature</th>
                        <th colspan='3'>Qualified Supervising Driver</th>
                    </tr>
                    <tr>
                        <th>Start am/pm</th>
                        <th>Finish am/pm</th>
                        <th>Duration (Minutes)</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Road</th>
                        <th>Weather</th>
                        <th>Traffic</th>
                        <th>Full Name</th>
                        <th>Licence No.</th>
                        <th>Signature</th>
                    </tr>
                    <?php

                        $sql = "SELECT * FROM logbooks LEFT JOIN users ON logbooks.qsd_id = users.id WHERE learner_id = ? AND confirmed = 1 AND time_of_day = 'Day' ORDER BY date DESC, start_time DESC;";
                        $stmt = mysqli_prepare($conn, $sql);
                        if ($_SESSION['user_type'] == 'learner') {
                            mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        } else {
                            mysqli_stmt_bind_param($stmt, "i", $_SESSION['student']["id"]);
                        }
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ( mysqli_num_rows($result) >= 1 ) {
                            while ($row = $result -> fetch_assoc()) {
                                echo "<tr>";
                                // <td>2023-09-01</td>
                                $date0 = date("d/m/Y", strtotime($row['date']));
                                echo "<td>$date0</td>";
                                // <td>08:30 AM</td>
                                $date = "{$row['date']} {$row['start_time']}";
                                $date = date("g:i A", strtotime($date));
                                echo "<td>{$date}</td>";
                                // <td>09:30 AM</td>
                                $date2 = "{$row['date']} {$row['end_time']}";
                                $date2 = date("g:i A", strtotime($date2));
                                echo "<td>{$date2}</td>";
                                // <td>60</td>
                                echo "<td>{$row['duration']}</td>";
                                // <td>Blackwood</td>
                                echo "<td>{$row['start_location']}</td>";
                                // <td>Marion</td>
                                echo "<td>{$row['end_location']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['road_type']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['weather']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['traffic']}</td>";
                                // <td>Signed</td>
                                if ($row['confirmed'] == 1) {
                                    echo "<td><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                    </svg> Signed</td>";
                                } else {
                                    echo "<td>Click here to sign</td>";
                                }
                                // <td>Kathryn Laneway</td>
                                echo "<td>{$row['username']}</td>";
                                // <td>KL1234</td>
                                echo "<td>{$row['license']}</td>";
                                // <td>Signed</td>
                                echo "<td><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                </svg> Signed</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>
                                <td colspan='13'>No entries.</td>
                            </tr>";

                        }

                    ?>
                </table>

            </div>

            <div id="Night" class="tabcontent tabcontent-black">

                <table>
                    <tr>
                        <th rowspan='2'>Date</th>
                        <th colspan='3'>Time</th>
                        <th colspan='2'>Location (Suburb)</th>
                        <th colspan='3'>Conditions</th>
                        <th rowspan='2'>Learners Signature</th>
                        <th colspan='3'>Qualified Supervising Driver</th>
                    </tr>
                    <tr>
                        <th>Start am/pm</th>
                        <th>Finish am/pm</th>
                        <th>Duration (Minutes)</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Road</th>
                        <th>Weather</th>
                        <th>Traffic</th>
                        <th>Full Name</th>
                        <th>Licence No.</th>
                        <th>Signature</th>
                    </tr>
                    <?php

                        $sql = "SELECT * FROM logbooks LEFT JOIN users ON logbooks.qsd_id = users.id WHERE learner_id = ? AND confirmed = 1 AND time_of_day = 'Night' ORDER BY date DESC, start_time DESC;";
                        $stmt = mysqli_prepare($conn, $sql);
                        if ($_SESSION['user_type'] == 'learner') {
                            mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                        } else {
                            mysqli_stmt_bind_param($stmt, "i", $_SESSION['student']["id"]);
                        }
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ( mysqli_num_rows($result) >= 1 ) {
                            while ($row = $result -> fetch_assoc()) {
                                echo "<tr>";
                                // <td>2023-09-01</td>
                                $date0 = date("d/m/Y", strtotime($row['date']));
                                echo "<td>$date0</td>";
                                // <td>08:30 AM</td>
                                $date = "{$row['date']} {$row['start_time']}";
                                $date = date("g:i A", strtotime($date));
                                echo "<td>{$date}</td>";
                                // <td>09:30 AM</td>
                                $date2 = "{$row['date']} {$row['end_time']}";
                                $date2 = date("g:i A", strtotime($date2));
                                echo "<td>{$date2}</td>";
                                // <td>60</td>
                                echo "<td>{$row['duration']}</td>";
                                // <td>Blackwood</td>
                                echo "<td>{$row['start_location']}</td>";
                                // <td>Marion</td>
                                echo "<td>{$row['end_location']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['road_type']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['weather']}</td>";
                                // <td>***</td>
                                echo "<td>{$row['traffic']}</td>";
                                // <td>Signed</td>
                                if ($row['confirmed'] == 1) {
                                    echo "<td><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                    </svg> Signed</td>";
                                } else {
                                    echo "<td>Click here to sign</td>";
                                }
                                // <td>Kathryn Laneway</td>
                                echo "<td>{$row['username']}</td>";
                                // <td>KL1234</td>
                                echo "<td>{$row['license']}</td>";
                                // <td>Signed</td>
                                echo "<td><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                </svg> Signed</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>
                                <td colspan='13'>No entries.</td>
                            </tr>";

                        }

                    ?>
                </table>

            </div>

            <div id="Summary" class="tabcontent">
                <?php
                    $sql = "SELECT sum(duration) as total_minutes FROM logbooks WHERE learner_id = ? AND confirmed = 1;";
                    $stmt = mysqli_prepare($conn, $sql);
                    if ($_SESSION['user_type'] == 'learner') {
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                    } else {
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION['student']["id"]);
                    }
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ( mysqli_num_rows($result) >= 1 ) {
                        if ($row = $result -> fetch_assoc()) {
                            $total_hours = intval($row['total_minutes'] / 60);
                            echo "<p><b>Total: </b> {$total_hours} / 75 hours</p>";
                        }
                    }
                ?>
                <?php
                    $sql = "SELECT sum(duration) as total_minutes FROM logbooks WHERE learner_id = ? AND confirmed = 1 AND time_of_day = 'Day';";
                    $stmt = mysqli_prepare($conn, $sql);
                    if ($_SESSION['user_type'] == 'learner') {
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                    } else {
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION['student']["id"]);
                    }
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ( mysqli_num_rows($result) >= 1 ) {
                        if ($row = $result -> fetch_assoc()) {
                            $total_hours = intval($row['total_minutes'] / 60);
                            echo "<p><b>Daytime: </b> {$total_hours} hours</p>";
                        }
                    }
                ?>
                <?php
                    $sql = "SELECT sum(duration) as total_minutes FROM logbooks WHERE learner_id = ? AND confirmed = 1 AND time_of_day = 'Night';";
                    $stmt = mysqli_prepare($conn, $sql);
                    if ($_SESSION['user_type'] == 'learner') {
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
                    } else {
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION['student']["id"]);
                    }
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if ( mysqli_num_rows($result) >= 1 ) {
                        if ($row = $result -> fetch_assoc()) {
                            $total_hours = intval($row['total_minutes'] / 60);
                            echo "<p><b>Night-time: </b> {$total_hours} / 15 hours</p>";
                        }
                    }
                ?>
            </div>
        </div>
</body>
</html>
