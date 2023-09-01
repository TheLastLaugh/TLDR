<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}

require_once "../inc/dbconn.inc.php"; 

$logbook_id = $_POST['logbook'];

$sql = "SELECT * FROM logbooks WHERE id = ?;";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $logbook_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$date = $row['date'];
$start_time = $row['start_time'];
$end_time = $row['end_time'];
$duration= $row['duration'];
$start_location = $row['start_location'];
$end_location = $row['end_location'];
$road_type = $row['road_type'];
$weather = $row['weather'];
$traffic = $row['traffic'];
$qsd_license = $row['qsd_license'];
$name = $_POST['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Alistair Macvicar" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Logbook Entry</title>
    <link rel="stylesheet" href="../styles/logbook-styles.css"/>
    <script src="../scripts/logbookScript.js"></script>
</head>
<body>
    <div id="banner">Logbook confirmation</div>
    <?php include_once "../inc/sidebar.inc.php"; ?>
    
    <h2>Logbook Details:</h2>
    <p><strong><?php echo $_SESSION['user_type'] == 'learner' ? 'QSD:' : 'Learner Name:'?></strong> <?php echo htmlspecialchars($name); ?></p>
    <p><strong>QSD License:</strong> <?php echo htmlspecialchars($qsd_license); ?></p>
    <p><strong>Date:</strong> <?php echo htmlspecialchars($date); ?></p>
    <p><strong>Start Time:</strong> <?php echo htmlspecialchars($start_time); ?></p>
    <p><strong>End Time:</strong> <?php echo htmlspecialchars($end_time); ?></p>
    <p><strong>Total Duration (minutes):</strong> <?php echo htmlspecialchars($duration); ?></p>
    <p><strong>Start Location:</strong> <?php echo htmlspecialchars($start_location); ?></p>
    <p><strong>End Location:</strong> <?php echo htmlspecialchars($end_location); ?></p>
    <p><strong>Road Type:</strong> <?php echo htmlspecialchars($road_type); ?></p>
    <p><strong>Weather:</strong> <?php echo htmlspecialchars($weather); ?></p>
    <p><strong>Traffic:</strong> <?php echo htmlspecialchars($traffic); ?></p>
    <button id="go_back">Back</button>
</body>
</html>
