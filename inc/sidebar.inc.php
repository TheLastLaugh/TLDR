<head>
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../scripts/sidebarScript.js" defer></script>
</head>
<div id="banner">
    <img id="menuIcon" src="../images/menu.png" alt="Menu Icon" style="width:40px;height:40px;">
    <?php echo "<div id =\"title\">Welcome to TLDR</div> <a href=\"../profile/profile.php\"><div id = \"banner-username\">".htmlspecialchars($_SESSION['username'])."</div>"; ?>
    <img id="profileIcon" src="../images/profile.png" alt="Profile Icon" style="width:40px;height:40px;"></a>
    
    
    
</div>
<div id="sidebar" style="width:0px;">
        <ul>
            <li><a href="../dashboard/welcome.php">Home</a></li>
            <li></li>
            <li><a href="../logbooks/logbook.php">Logbook</a></li>
            <li><a href="../payments/payments.php">Payments</a></li>
            <li><a href="../lessons/lessons.php">Lessons</a></li>
            <li><a href="../login/logout.php">Logout</a></li>
            <li><a href="#">Help</a></li>
        </ul>
</div>