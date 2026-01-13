<?php
$conn = mysqli_connect("localhost", "root", "", "hospital_db");

if (!$conn) {
    echo "Database connection failed";
}
?>