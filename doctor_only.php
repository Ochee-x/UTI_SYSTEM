<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// Check if user is a doctor
if ($_SESSION['role'] !== 'doctor') {
    // hindi doctor → pwede rin i-redirect sa admin dashboard o logout
    header("Location: login.php");
    exit();
}
?>