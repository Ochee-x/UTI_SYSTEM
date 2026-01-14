<?php
include("auth_check.php"); // Siguraduhin na may session_start() sa loob nito
include("db.php");

// Count total patients
$patient_result = mysqli_query($conn, "SELECT COUNT(*) AS total_patients FROM patients");
$patient_count = mysqli_fetch_assoc($patient_result)['total_patients'];

// Count total doctors
$doctor_result = mysqli_query($conn, "SELECT COUNT(*) AS total_doctors FROM doctors");
$doctor_count = mysqli_fetch_assoc($doctor_result)['total_doctors'];

// Count total appointments
$appointment_result = mysqli_query($conn, "SELECT COUNT(*) AS total_appointments FROM appointments");
$appointment_count = mysqli_fetch_assoc($appointment_result)['total_appointments'];

// Count pending appointments
$pending_result = mysqli_query($conn, "SELECT COUNT(*) AS total_pending FROM appointments WHERE status='Pending'");
$pending_count = mysqli_fetch_assoc($pending_result)['total_pending'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">City Hospital</div>
        <ul class="nav-links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="patients/view_patients.php">Patients</a></li>
            <li><a href="doctors/view_doctors.php">Doctors</a></li>
            <li><a href="appointments/view_appointment.php">Appointments</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </div>

    <div class="container">
        <h1>Hospital Management Dashboard</h1>
        <p>Welcome, <strong><?php echo $_SESSION['username']; ?></strong>! You have successfully logged in.</p>
       
        <div class="stats">
            <div class="stat-box">
                <h3>Total Patients</h3>
                <p><?php echo $patient_count; ?></p>
                <a href="patients/view_patients.php" class="stat-link">View Details</a>
            </div>

            <div class="stat-box">
                <h3>Total Doctors</h3>
                <p><?php echo $doctor_count; ?></p>
                <a href="doctors/view_doctors.php" class="stat-link">View Details</a>
            </div>

            <div class="stat-box">
                <h3>Total Appointments</h3>
                <p><?php echo $appointment_count; ?></p>
                <a href="appointments/view_appointment.php" class="stat-link">View Details</a>
            </div>

            <div class="stat-box">
                <h3>Pending Appointments</h3>
                <p><?php echo $pending_count; ?></p>
                <a href="appointments/view_appointment.php" class="stat-link">View Details</a>
            </div>
        </div>
    </div>
</body>
</html>
