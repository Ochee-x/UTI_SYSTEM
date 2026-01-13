<?php
include("../auth_check.php");
include("../db.php");

$result = mysqli_query($conn, "SELECT * FROM patients");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Patients</title>
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
    <h2>Patient List</h2>
    <a href="add_patients.php">➕ Add Patient</a>

    <table border="1" width="100%" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['fullname']; ?></td>
            <td><?= $row['age']; ?></td>
            <td><?= $row['gender']; ?></td>
            <td><?= $row['contact']; ?></td>
            <td>
                <a href="edit_patients.php?id=<?= $row['id']; ?>">Edit</a> |
                <a href="delete_patient.php?id=<?= $row['id']; ?>" 
                   onclick="return confirm('Delete this patient?');">
                   Delete
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
