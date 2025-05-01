<?php 
session_start();
if (!isset($_SESSION['username'])) {
    // Not logged in
    header("Location: login.php");
    exit();
}

?>

<a href="logout.php">Logout</a>