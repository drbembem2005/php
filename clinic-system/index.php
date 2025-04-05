<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include_once 'includes/header.php';

echo "<div class='container'><h1>Clinic System Dashboard</h1><p>Welcome, " . htmlspecialchars($_SESSION['username']) . " (" . htmlspecialchars($_SESSION['role']) . ")</p></div>";

include_once 'includes/footer.php';
?>
