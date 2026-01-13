<?php
include("../auth_check.php");
include("../db.php");

if (isset($_POST['save'])) {
    $fullname = $_POST['fullname'];
    $specialization = $_POST['specialization'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];

    $query = "INSERT INTO doctors 
              (fullname, specialization, contact, gender)
              VALUES 
              ('$fullname', '$specialization', '$contact', '$gender')";

    mysqli_query($conn, $query);
    header("Location: /hospital_system/doctors/view_doctors.php");
    exit();

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Doctor</title>
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
    <h2>Add Doctor</h2>

    <form action="/hospital_system/doctors/add_doctor.php" method="POST">

        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="text" name="specialization" placeholder="Specialization" required>

        <select name="gender" required>
            <option value="">Select Gender</option>
            <option>Male</option>
            <option>Female</option>
        </select>

        <input type="text" name="contact" placeholder="Contact Number" required>

        <button type="submit" name="save">Save Doctor</button>
    </form>
</div>

</body>
</html>
