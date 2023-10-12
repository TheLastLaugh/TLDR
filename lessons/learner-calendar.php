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

// Uses the database connection and sidebar file
require_once "../inc/dbconn.inc.php"; 
include_once "../inc/sidebar.inc.php";


function getUpcomingLessons($user_id, $conn,$date,$time) {
    $sql = "SELECT b.*, u.username FROM bookings AS b JOIN users as u on b.instructor_id = u.id WHERE b.learner_id = ? AND b.booking_date = ? AND b.booking_time = ?";
    $statement = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($statement, $sql);
    mysqli_stmt_bind_param($statement,'iss', $user_id ,$date, $time);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($row = mysqli_fetch_assoc($result)){
        echo("<td class = \"booked\"><b>".$row["username"]."</b><br>".$row["pickup_location"]."</td>");
        return true;
    } else {
        echo("<td></td>");
        return true;
    }
}

function getInstructors($conn,$date){
    $instructorSQL = "SELECT username, id FROM users WHERE user_type = \"instructor\"";
    $instructorSTATE = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($instructorSTATE, $instructorSQL);
    mysqli_stmt_execute($instructorSTATE);
    $result = mysqli_stmt_get_result($instructorSTATE);

    
    while($row = mysqli_fetch_assoc($result)){
        if(isset($_GET['instructor'])){
            $placeholder = str_replace( '-',' ',$_GET['instructor']);
        } else {
            $placeholder = null;
            $_SESSION["instructor_id"] = -1;
        }
        if($row["username"] != $placeholder){
            $instructorName = str_replace( ' ','-',$row["username"]);
            echo("<a href = learner-calendar.php?date=".$date."&instructor=". $instructorName . "><b>".$row["username"]."</b></a>");
        } else {
            $_SESSION["instructor_id"] = $row["id"];
        }
    }
    if($placeholder != null){
        echo("<a href = learner-calendar.php?date=".$date.">Your Bookings" . "</a");
    }
}

function fill_cell($conn, $date, $time){
        if($_SESSION["instructor_id"] == -1){
            getUpcomingLessons($_SESSION["userid"],$conn,$date,$time);
            return;
        }

                $sql = "SELECT booking_id FROM bookings WHERE booking_date = ? AND booking_time = ? AND instructor_id = ?";
                $statement = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($statement, $sql);
                mysqli_stmt_bind_param($statement,'ssi',$date, $time, $_SESSION["instructor_id"]);
                mysqli_stmt_execute($statement);
                $result = mysqli_stmt_get_result($statement);
                
                if(mysqli_num_rows($result) == 1){
                    echo("<td class = \"full\"></td>");
                    return;
                }

                echo("  
                        <td class = \"used\">
                            <form action=\"lessons.php?date=".$date.'&time='.$time."\">
                                <input type = \"hidden\" name= \"date\" value = \"".$date."\" ></input>
                                <input type = \"hidden\" name= \"instructorID\" value = \"".$_SESSION["instructor_id"]."\" ></input>
                                <input type = \"submit\" class = \"cell_button\" name = \"time\" value = \"".$time."\"></input>
                            </form>
                        </td>
                    ");
          
}

function get_learner_name($user_id, $conn){
    $sql = "SELECT username FROM users WHERE id = $user_id";
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
    $current_day = date("l",strtotime($current_date));
}
else if($current_day == "Sunday"){
    $current_date = date('d-m-Y', strtotime('+1 days'));
    $current_day = date("l",strtotime($current_date));
}
else {
    while($current_day != "Monday"){
        $current_date = date('d-m-Y', strtotime('-1 day',strtotime($current_date)));
        $current_day = date("l", strtotime($current_date));
    }
}

$_POST['monday_date'] = $current_date;

if(isset($_GET['instructor'])){
    $filter = str_replace('-', ' ', $_GET['instructor']);
} else { 
    $filter = "Your Bookings";
    $instructorID = null;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Darcy Foster" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons</title>
    <link rel="stylesheet" href="../styles/styles.css"/>
    <link rel="stylesheet" href="../styles/calendar.css"/>
    <script src = "../scripts/dropdown.js" ></script>
</head>
<body>
    <div id = 'content'>

        <div id = 'calendar-menu' >
            <form  id = "leftIcon"  action = "learner-calendar.php" method="get" >
                <button type = "submit" name="date" value = <?php echo(date("d-m-Y", strtotime("-7 days",strtotime($current_date)))) ?> formmethod="get" >
                    <img type = "image"src = "../images/arrow_back.png" alt = "Left Icon" style = "width:40px;height:40px;">
                </button>
            </form>
            <form  id = "rightIcon"  action = "learner-calendar.php" method="get" >
                <button type = "submit" name="date" value = <?php echo(date("d-m-Y", strtotime("+7 days",strtotime($current_date)))) ?> formmethod="get">
                    <img type = "image"src = "../images/arrow_forward.png" alt = "Left Icon" style = "width:40px;height:40px;">
                </button>
            </form>
            <form id = "change-date" action = "learner-calendar.php" method="get">
                <input type="date" id = "date-picker" name = "date" value = "<?php echo(date("Y-m-d",strtotime($current_date)))?>">
                <input type="hidden" name = "instructor" value = "<?php echo($filter);?>">
                <input type = "submit" id = "accept-date" value = "">
            </form>
                
                <div class = "dropdown">
                    <button id = "studentBtn" class = "dropbtn" onclick="dropdown()"> <?php echo($filter) ?> <img src = "../images/dropdown-Icon.png" /></button>
                    <div class = "dropdown-content" id = "myDropdown">
                        <?php getInstructors($conn,$current_date,)  ?>       
                    </div>
                </div>
                        
            
            
            
            
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