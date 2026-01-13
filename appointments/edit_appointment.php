<?php
include("../auth_check.php");
include("../db.php");

$id = $_GET['id'];

$appointment = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM appointments WHERE id=$id")
);

$patients = mysqli_query($conn, "SELECT * FROM patients");
$doctors = mysqli_query($conn, "SELECT * FROM doctors");

if (isset($_POST['update'])) {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $status = $_POST['status'];

    $query = "UPDATE appointments SET
              patient_id='$patient_id',
              doctor_id='$doctor_id',
              appointment_date='$appointment_date',
              status='$status'
              WHERE id=$id";

    mysqli_query($conn, $query);
    header("Location: view_appointments.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Appointment</title>
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
    <h2>Edit Appointment</h2>

    <form method="POST">

        <label>Patient</label>
        <select name="patient_id">
            <?php while ($p = mysqli_fetch_assoc($patients)) { ?>
                <option value="<?= $p['id']; ?>"
                    <?= $p['id'] == $appointment['patient_id'] ? 'selected' : '' ?>>
                    <?= $p['fullname']; ?>
                </option>
            <?php } ?>
        </select>

        <label>Doctor</label>
        <select name="doctor_id">
            <?php while ($d = mysqli_fetch_assoc($doctors)) { ?>
                <option value="<?= $d['id']; ?>"
                    <?= $d['id'] == $appointment['doctor_id'] ? 'selected' : '' ?>>
                    <?= $d['fullname']; ?>
                </option>
            <?php } ?>
        </select>

        <label>Date</label>
        <input type="date" name="appointment_date"
               value="<?= $appointment['appointment_date']; ?>">

        <label>Status</label>
        <select name="status">
            <option><?= $appointment['status']; ?></option>
            <option>Pending</option>
            <option>Approved</option>
            <option>Completed</option>
        </select>

        <button type="submit" name="update">Update Appointment</button>
    </form>
</div>

</body>
</html>
