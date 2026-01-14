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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <style>
    /* ====== NEW CSS START ====== */

    body {
        font-family: Arial, sans-serif;
        background: #f3f4f6;
        margin: 0;
        padding: 0;
    }

    .container {
        background: #ffffff;
        padding: 40px;
        margin: 50px auto;
        border-radius: 12px;
        max-width: 1000px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .welcome-text {
        font-size: 18px;
        color: #34495e;
        margin-bottom: 25px;
    }

    .appointments-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Segoe UI', sans-serif;
    }

    .appointments-table th, .appointments-table td {
        padding: 14px 12px;
        text-align: left;
    }

    .appointments-table th {
        background-color: #3498db;
        color: #ffffff;
        font-weight: 600;
        text-transform: uppercase;
    }

    .appointments-table tr {
        transition: all 0.3s ease;
        cursor: default;
    }

    .appointments-table tr:hover {
        background-color: #f0f8ff;
    }

    .appointments-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr.pending td:nth-child(4) {
        color: #d97706;
        font-weight: bold;
    }

    tr.done td:nth-child(4) {
        color: #16a34a;
        font-weight: bold;
    }

    tr.cancelled td:nth-child(4) {
        color: #dc2626;
        font-weight: bold;
    }

    .btn.done-btn {
        background-color: #10b981;
        color: #ffffff;
        padding: 6px 14px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s;
    }

    .btn.done-btn:hover {
        background-color: #059669;
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .appointments-table th, .appointments-table td {
            padding: 10px 8px;
            font-size: 14px;
        }

        .container {
            padding: 25px;
            margin: 20px auto;
        }
    }

    /* ====== NEW CSS END ====== */
    </style>
</head>
<body>

<div class="container">
    <h2>Doctor Dashboard</h2>
    <p class="welcome-text">Welcome, Dr. <?= $doctor_name ?>!</p>

    <h3>My Appointments</h3>
    <table class="appointments-table">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr class="<?= strtolower($row['status']); ?>">
                <td><?= $row['patient_name']; ?></td>
                <td><?= date("F j, Y", strtotime($row['appointment_date'])); ?></td>
                <td><?= date("h:i A", strtotime($row['appointment_time'])); ?></td>
                <td><?= $row['status']; ?></td>
                <td>
                    <?php if ($row['status'] !== 'Done') { ?>
                        <a href="mark_done.php?id=<?= $row['id']; ?>" class="btn done-btn">Mark as Done</a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
