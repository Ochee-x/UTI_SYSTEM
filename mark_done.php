<?php
include("auth_check.php");
include("doctor_only.php");
include("db.php");

$id = $_GET['id'];
$doctor_id = $_SESSION['doctor_id'];

$query = "UPDATE appointments
          SET status = 'Done'
          WHERE id = $id
          AND doctor_id = $doctor_id";

mysqli_query($conn, $query);

header("Location: doctor_dashboard.php");
exit();
