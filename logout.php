<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    if (isset($_SESSION['user_id'])) {
        // User is logged in, proceed with logout
        session_unset();
        session_destroy();
        header("Location: final.php");
        exit();
    } else {
        // User is not logged in, redirect to final page
        header("Location: final.php");
        exit();
    }
} else {
    header("Location: final.php");
    exit();
}
?>
