<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not, send them back to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}
// If the user isn't a learner, don't give them access to this page
else if ($_SESSION['user_type'] != 'instructor') {
    header("Location: ../dashboard/welcome.php");
    exit;
}

// Uses the database connection and sidebar file
require_once "../inc/dbconn.inc.php"; 
include_once "../inc/sidebar.inc.php";

function fill_cell($conn, $date = "2023-10-11", $time = "12:00:00"){
    $sql = "SELECT learner_id, pickup_location FROM bookings WHERE instructor_id = ? AND date = ? AND time = ?";

    $statement = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($statement, $sql);
    mysqli_stmt_bind_param($statement, "iss", $_SESSION["userid"],$date, $time);
    mysqli_stmt_execute($statement);

    $result = mysqli_fetch_assoc(mysqli_stmt_get_result($statement));
    if(isset($result)){
        $learner = get_learner_name($result["learner_id"],$conn);
        echo("<td><b>" . $learner . "</b><br>" . $result["pickup_location"]."</td>");
    } else {
        echo("<td></td>");
    }
        
}

function get_learner_name($learner_id, $conn){
    $sql = "SELECT username FROM users WHERE id = $learner_id";
    $value = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    return $value["username"];
}

function fill_row($conn,$current_date,$time){
    for($i = 0; $i < 5; $i++){
        fill_cell($conn,date('Y-m-d', strtotime('+'.$i.' day',strtotime($current_date))),$time);
    }
}
function left_press($date){
    $date = date('d-m-Y', strtotime('-7 days',strtotime($date)));
    return $date;
}
function right_press($date){
    $date = date('d-m-Y', strtotime('+7 days',strtotime($date)));
    return $date;
}


date_default_timezone_set("Australia/Adelaide");
#GET MONDAY OF WEEK
if(isset($_GET['date'])){
    $current_date = date('d-m-Y', strtotime($_GET['date']));
}
else{
    $current_date = date('d-m-Y');
}
$current_day = date("l",strtotime($current_date));

if($current_day == "Saturday"){
    $current_date = date('d-m-Y', strtotime('+2 days'));
    $current_day = date("l",$current_date);
}
else if($current_day == "Sunday"){
    $current_date = date('d-m-Y', strtotime('+1 days'));
    $current_day = date("l",$current_date);
}
else {
    while($current_day != "Monday"){
        $current_date = date('d-m-Y', strtotime('-1 day',strtotime($current_date)));
        $current_day = date("l", strtotime($current_date));
    }
}

$_SESSION['monday_date'] = $current_date;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Darcy Foster" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" href="../styles/styles.css"/>
    <link rel="stylesheet" href="../styles/calendar.css"/>
    <script src="calendar.js"></script>
</head>
<body>
    <div id = 'content'>

        <div id = 'calendar-menu' >
            <form  id = "leftIcon"  action = "calendar.php" method="get" >
                <button type = "submit" name="date" value = <?php echo(date("d-m-Y", strtotime("-7 days",strtotime($current_date)))) ?> formmethod="get" >
                    <img type = "image"src = "../images/arrow_back.png" alt = "Left Icon" style = "width:40px;height:40px;">
                </button>
            </form>

            <form  id = "rightIcon"  action = "calendar.php" method="get" >
                <button type = "submit" name="date" value = <?php echo(date("d-m-Y", strtotime("+7 days",strtotime($current_date)))) ?> formmethod="get">
                    <img type = "image"src = "../images/arrow_forward.png" alt = "Left Icon" style = "width:40px;height:40px;">
                </button>
            </form>
            <img id="gearIcon" src="../images/gearIcon.png" alt="Gear Icon" style="width:40px;height:40px;" >
            
            
        </div>

        <table>
            <tr> <!-- Header -->
                <th id = 'time-header'>Time</th>
                <th>Monday <?php echo('('.$current_date.')')  ?></th>
                <th>Tuesday <?php echo('('. date('d-m-Y', strtotime('+1 day',strtotime($current_date)))).')'?></th>
                <th>Wednesday <?php echo('('. date('d-m-Y', strtotime('+2 day',strtotime($current_date)))).')'?></th>
                <th>Thursday <?php echo('('. date('d-m-Y', strtotime('+3 day',strtotime($current_date)))).')'?></th>
                <th>Friday <?php echo('('. date('d-m-Y', strtotime('+4 day',strtotime($current_date)))).')'?></th>
            </tr>

            <tr>
                <td class = "time">9am</td>
                <?php echo(fill_row($conn,$current_date,"9:00:00"))?>
            </tr>

            <tr>
                <td class = "time">10am</td>
                <?php echo(fill_row($conn,$current_date,"10:00:00"))?>
            </tr>

            <tr>
                <td class = "time">11am</td>
                <?php echo(fill_row($conn,$current_date,"11:00:00"))?>
            </tr>
            
            <tr>
                <td class = "time">12pm</td>
                <?php echo(fill_row($conn,$current_date,"12:00:00"))?>
            </tr>

            <tr>
                <td class = "time">1pm</td>
                <?php echo(fill_row($conn,$current_date,"13:00:00"))?>
            </tr>

            <tr>
                <td class = "time">2pm</td>
                <?php echo(fill_row($conn,$current_date,"14:00:00"))?>
            </tr>

            <tr>
                <td class = "time">3pm</td>
                <?php echo(fill_row($conn,$current_date,"15:00:00"))?>
            </tr>

            <tr>
                <td class = "time">4pm</td>
                <?php echo(fill_row($conn,$current_date,"16:00:00"))?>
            </tr>

            <tr>
                <td class = "time">5pm</td>
                <?php echo(fill_row($conn,$current_date,"17:00:00"))?>
            </tr>

        

        </table>
    </div>
</body>
</html>