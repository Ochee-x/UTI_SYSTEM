<?php
include("../auth_check.php");
include("../db.php");

if (isset($_POST['save'])) {
    $fullname = $_POST['fullname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $query = "INSERT INTO patients 
              (fullname, age, gender, contact, address)
              VALUES 
              ('$fullname', '$age', '$gender', '$contact', '$address')";

    mysqli_query($conn, $query);

    header("Location: /hospital_system/patients/view_patients.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Patient</title>
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
    <h2>Add Patient</h2>

    <form action="/hospital_system/patients/add_patients.php" method="POST">

        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="number" name="age" placeholder="Age" required>

        <select name="gender" required>
            <option value="">Select Gender</option>
            <option>Male</option>
            <option>Female</option>
        </select>

        <input type="text" name="contact" placeholder="Contact Number" required>
        <textarea name="address" placeholder="Address"></textarea>

        <button type="submit" name="save">Save Patient</button>
    </form>
</div>

</body>
</html>
