<?php
include("doctor_only.php"); // check if doctor
include("db.php");

$doctor_id = $_SESSION['doctor_id']; // numeric ID ng doctor

// --- Get all appointments for this doctor with patient name ---
$query = "SELECT appointments.id,
                 patients.fullname AS patient_name,
                 appointments.appointment_date,
                 appointments.appointment_time,
                 appointments.status
          FROM appointments
          JOIN patients ON appointments.patient_id = patients.id
          WHERE appointments.doctor_id = $doctor_id";

$result = mysqli_query($conn, $query);

// Get doctor name from session
$doctor_name = $_SESSION['username'];
?>

<h2>Doctor Dashboard</h2>
<p>Welcome Doctor <?php echo $doctor_name; ?>!</p>

<h3>My Appointments</h3>
<table border="1" cellpadding="10">
    <tr>
        <th>Patient</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr class="<?= $row['status'] === 'Done' ? 'done' : '' ?>">
    <td><?= $row['patient_name']; ?></td>
    <td><?= $row['appointment_date']; ?></td>
    <td><?= date("h:i A", strtotime($row['appointment_time'])); ?></td>
    <td><?= $row['status']; ?></td>
    <td>
        <?php if ($row['status'] !== 'Done') { ?>
            <a href="mark_done.php?id=<?= $row['id']; ?>">Mark as Done</a>
        <?php } ?>
    </td>
</tr>
<?php } ?>
</table>
