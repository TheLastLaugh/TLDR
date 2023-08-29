<?php
// ENVIRONMENT VARIABLES
define("DB_HOST", "localhost");
define("DB_NAME", "TLDR");
define("DB_USER", "dbadmin"); //da bad man
define("DB_PASS", "");

// Connect to database
$conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Hopefully you never see this...
if (!$conn) {
    echo "Error: Unable to connect to database.<br>";
    echo "Debugging errno: " . mysqli_connect_errno() . "<br>";
    echo "Debugging error: " . mysqli_connect_error() . "<br>";
    exit;
}
