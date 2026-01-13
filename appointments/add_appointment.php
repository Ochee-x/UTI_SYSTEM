<?php
include("../auth_check.php");
include("../db.php");

// Fetch patients
$patients = mysqli_query($conn, "SELECT * FROM patients");

// Fetch doctors
$doctors = mysqli_query($conn, "SELECT * FROM doctors");

if (isset($_POST['save'])) {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $status = "Pending";

     $check = mysqli_query($conn, "
        SELECT id FROM appointments
        WHERE doctor_id = '$doctor_id'
        AND appointment_date = '$appointment_date'
        AND appointment_time = '$appointment_time'
    ");

    if (mysqli_num_rows($check) > 0) {
        echo "<script>
        alert('This doctor already has an appointment at this time. Please choose another time.');
        </script>";
    } else {

   $query = "INSERT INTO appointments 
          (patient_id, doctor_id, appointment_date, appointment_time, status)
          VALUES 
          ('$patient_id', '$doctor_id', '$appointment_date', '$appointment_time', '$status')";


    mysqli_query($conn, $query);
    
    header("Location: /hospital_system/appointments/view_appointment.php");
    exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Appointment</title>
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
    <h2>Add Appointment</h2>

    <form action="/hospital_system/appointments/add_appointment.php" method="POST">


        <label>Patient</label>
        <select name="patient_id" required>
            <option value="">Select Patient</option>
            <?php while ($p = mysqli_fetch_assoc($patients)) { ?>
                <option value="<?= $p['id']; ?>">
                    <?= $p['fullname']; ?>
                </option>
            <?php } ?>
        </select>

        <label>Doctor</label>
        <select name="doctor_id" required>
            <option value="">Select Doctor</option>
            <?php while ($d = mysqli_fetch_assoc($doctors)) { ?>
                <option value="<?= $d['id']; ?>">
                    <?= $d['fullname']; ?> (<?= $d['specialization']; ?>)
                </option>
            <?php } ?>
        </select>

        <label>Appointment Date</label>
        <input type="date" name="appointment_date" required>

        <label>Appointment Time</label>
        <input type="time" name="appointment_time" required>


        <button type="submit" name="save">Save Appointment</button>
    </form>
</div>

</body>
</html>
