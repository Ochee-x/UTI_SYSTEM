<?php
include("../auth_check.php");
include("../db.php");

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM doctors WHERE id=$id");
$doctor = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $fullname = $_POST['fullname'];
    $specialization = $_POST['specialization'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];

    $query = "UPDATE doctors SET
              fullname='$fullname',
              specialization='$specialization',
              contact='$contact',
              gender='$gender'
              WHERE id=$id";

    mysqli_query($conn, $query);
    header("Location: view_doctors.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Doctor</title>
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
    <h2>Edit Doctor</h2>

    <form method="POST">
        <input type="text" name="fullname" value="<?= $doctor['fullname']; ?>" required>
        <input type="text" name="specialization" value="<?= $doctor['specialization']; ?>" required>

        <select name="gender">
            <option><?= $doctor['gender']; ?></option>
            <option>Male</option>
            <option>Female</option>
        </select>

        <input type="text" name="contact" value="<?= $doctor['contact']; ?>" required>

        <button type="submit" name="update">Update Doctor</button>
    </form>
</div>

</body>
</html>
