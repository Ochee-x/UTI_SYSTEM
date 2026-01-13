<?php
include("../auth_check.php");
include("../db.php");

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM patients WHERE id=$id");
$patient = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $fullname = $_POST['fullname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $query = "UPDATE patients SET
              fullname='$fullname',
              age='$age',
              gender='$gender',
              contact='$contact',
              address='$address'
              WHERE id=$id";

    mysqli_query($conn, $query);
    header("Location: view_patients.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Patient</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
 <!-- Navbar: put this in all pages -->
<div class="navbar">
    <div class="logo">City Hospital</div>
    <ul class="nav-links">
        <li><a href="/hospital_system/dashboard.php">Dashboard</a></li>
        <li><a href="/hospital_system/patients/view_patients.php">Patients</a></li>
        <li><a href="/hospital_system/doctors/view_doctors.php">Doctors</a></li>
        <li><a href="/hospital_system/appointments/view_appointment.php">Appointments</a></li>
        <li><a href="/hospital_system/logout.php" class="logout">Logout</a></li>
    </ul>
</div>



<div class="container">
    <h2>Edit Patient</h2>

    <form method="POST">
        <input type="text" name="fullname" value="<?= $patient['fullname']; ?>" required>
        <input type="number" name="age" value="<?= $patient['age']; ?>" required>

        <select name="gender">
            <option><?= $patient['gender']; ?></option>
            <option>Male</option>
            <option>Female</option>
        </select>

        <input type="text" name="contact" value="<?= $patient['contact']; ?>" required>
        <textarea name="address"><?= $patient['address']; ?></textarea>

        <button type="submit" name="update">Update Patient</button>
    </form>
</div>

</body>
</html>
