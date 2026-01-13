<?php
include("../auth_check.php");
include("../db.php");

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM patients WHERE id=$id");

header("Location: view_patients.php");
?>
