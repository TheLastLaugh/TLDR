<?php
// Initialise session
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/index.php");
    exit;
}

// If the user is a learner, don't give them access to this page
else if ($_SESSION['user_type'] == 'learner') {
    header("Location: ../dashboard/welcome.php");
    exit;
}

// If the user is a qsd, don't give them access to this page
else if ($_SESSION['user_type'] == 'qsd') {
    header("Location: ../dashboard/welcome-qsd.php");
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
    <title>CBT&A</title>
    <link rel="stylesheet" href="../styles/cbt&a.css"/>
    <script type="text/javascript" src="./cbt&a.js" defer></script>
</head>
<body>
    <!-- <div id="banner">Search Student</div> -->
    
    <?php include_once "../inc/sidebar.inc.php"; ?>

    <?php

        if (isset($_SESSION['student']['username'])) {
            $studentname = $_SESSION['student']['username'];
        } 

        echo "
        <div id='dashboard'>
            <div id='content'>

                <p>Student Name: {$studentname}</p>
                <a href='../search/search.php?usertype=student'>Change Student</a><br>
                <p>Please select a unit and task below.</p>

                <button id='unit-1' class='accordion'>Unit 1 - Basic driving procedures</button>
                <div class='panel'>
                    <table>
                        <tr>
                            <td><a href='#view-task' onclick='viewTask(1)'>1. Cabin drills and controls</a></td>
                            <td id='task-1-status'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                            <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Task Incomplete</td>
                        </tr>
                        <tr>
                            <td><a href='#view-task' onclick='viewTask(2)'>2. Starting up and shutting down the engine</a></td>
                            <td id='task-2-status'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                            <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Task Incomplete</td>
                        </tr>
                        <tr>
                            <td><a href='#view-task' onclick='viewTask(3)'>3. Moving off from the kerb</a></td>
                            <td id='task-3-status'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                            <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Task Incomplete</td>
                        </tr>
                        <tr>
                            <td><a href='#view-task' onclick='viewTask(4)'>4. Stopping and securing the vehicle</a></td>
                            <td id='task-4-status'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                            <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Task Incomplete</td>
                        </tr>
                        <tr>
                            <td><a href='#view-task' onclick='viewTask(5)'>5. Stop and go (using the park brake)</a></td>
                            <td id='task-5-status'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                            <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Task Incomplete</td>
                        </tr>
                        <tr>
                            <td><a href='#view-task' onclick='viewTask(6)'>6. Gear changing (up and down)</a></td>
                            <td id='task-6-status'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                            <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Task Incomplete</td>
                        </tr>
                        <tr>
                            <td><a href='#view-task' onclick='viewTask(7)'>7. Steering (forward and reverse)</a></td>
                            <td id='task-7-status'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                            <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Task Incomplete</td>
                        </tr>
                        <tr>
                            <td><a href='#view-task' onclick='viewTask(8)'>8. Review of all basic driving procedures</a></td>
                            <td id='task-8-status'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                            <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Task Incomplete</td>
                        </tr>
                    </table>
                </div>

                <button id='unit-2' class='accordion'>Unit 2 - Slow speed manoeuvres</button>
                <div class='panel'>
                <p>Lorem ipsum...</p>
                </div>

                <button id='unit-3' class='accordion'>Unit 3 - Basic road skills</button>
                <div class='panel'>
                <p>Lorem ipsum...</p>
                </div>

                <button id='unit-4' class='accordion'>Unit 4 - Traffic Management Skills</button>
                <div class='panel'>
                <p>Lorem ipsum...</p>
                </div>

                <button id='unit-5' class='accordion'>Units 1 & 2 - Review</button>
                <div class='panel'>
                <p>Lorem ipsum...</p>
                </div>

                <button id='unit-6' class='accordion'>Units 3 & 4 - Review</button>
                <div class='panel'>
                    <table>
                        <tr>
                            <td><a href='#view-task' onclick='viewTask(30)'>30. Review of road skills and traffic management</a></td>
                            <td><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                            <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                          </svg> Task Incomplete</td>
                        </tr>
                    </table>
                </div>

                <br><br>

                <div id='view-task'>
                </div>
            
            </div>
        </div>";

    ?>

</body>
</html>
