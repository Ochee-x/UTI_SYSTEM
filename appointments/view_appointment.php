<?php
include("../auth_check.php");
include("../db.php");

$query = "SELECT appointments.id,
                 patients.fullname AS patient_name,
                 doctors.fullname AS doctor_name,
                 appointments.appointment_date,
                 appointments.appointment_time,
                 appointments.status
          FROM appointments
          JOIN patients ON appointments.patient_id = patients.id
          JOIN doctors ON appointments.doctor_id = doctors.id";


$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Appointments</title>
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

<tr class="<?= $row['status'] === 'Done' ? 'done' : '' ?>">


<div class="container">
    <h2>Appointment List</h2>
    <a href="add_appointment.php">➕ Add Appointment</a>

    <table border="1" width="100%" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['patient_name']; ?></td>
            <td><?= $row['doctor_name']; ?></td>
            <td><?= $row['appointment_date']; ?></td>
            <td><?= date("h:i A", strtotime($row['appointment_time'])) ?></td>
            <td><?= $row['status']; ?></td>
            <td>
                <a href="edit_appointment.php?id=<?= $row['id']; ?>">Edit</a> |
                <a href="delete_appointment.php?id=<?= $row['id']; ?>"
                   onclick="return confirm('Delete this appointment?');">
                   Delete
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
