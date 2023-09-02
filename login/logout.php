<?php
// Initialise session
session_start();

// Destroy the session (log out)
session_destroy();

// Redirect to the login page
header("Location: ./index.php");

// terminate the script
exit();
?>
