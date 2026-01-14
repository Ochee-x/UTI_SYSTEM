<?php
include("doctor_only.php"); // check if doctor
include("db.php");

$doctor_id = $_SESSION['doctor_id']; 
$doctor_name = $_SESSION['username'];

// --- Get all appointments for this doctor with patient name ---
$query = "SELECT appointments.id,
                 patients.fullname AS patient_name,
                 appointments.appointment_date,
                 appointments.appointment_time,
                 appointments.status
          FROM appointments
          JOIN patients ON appointments.patient_id = patients.id
          WHERE appointments.doctor_id = $doctor_id
          ORDER BY appointments.appointment_date DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
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
            position: relative; /* Necessary for absolute logout button */
        }

        /* Header & Logout */
        .dashboard-header {
            margin-bottom: 30px;
        }

        .logout-btn {
            position: absolute;
            top: 30px;
            right: 40px;
            background-color: #fef2f2;
            color: #dc2626;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
            border: 1px solid #fecaca;
        }

        .logout-btn:hover {
            background-color: #dc2626;
            color: white;
        }

        .welcome-text {
            font-size: 18px;
            color: #64748b;
            margin-top: 5px;
        }

        /* Table Styling */
        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .appointments-table th {
            background-color: #3498db;
            color: #ffffff;
            padding: 14px 12px;
            text-align: left;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .appointments-table td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }

        .appointments-table tr:hover {
            background-color: #f8fafc;
        }

        /* Status Colors */
        .status-done { color: #16a34a; font-weight: bold; }
        .status-pending { color: #d97706; font-weight: bold; }
        .status-cancelled { color: #dc2626; font-weight: bold; }

        /* Action Button */
        .btn.done-btn {
            background-color: #10b981;
            color: #ffffff;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            transition: 0.3s;
            display: inline-block;
        }

        .btn.done-btn:hover {
            background-color: #059669;
            transform: translateY(-1px);
        }

        /* MODAL STYLES */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 25px;
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-confirm {
            background: #dc2626;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="#" class="logout-btn" onclick="openLogoutModal(event)">Logout</a>

    <div class="dashboard-header">
        <h2>Doctor Dashboard</h2>
        <p class="welcome-text">Welcome, Dr. <?= htmlspecialchars($doctor_name) ?>!</p>
    </div>

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
            <?php while ($row = mysqli_fetch_assoc($result)) { 
                $statusClass = "status-" . strtolower($row['status']);
            ?>
            <tr>
                <td><strong><?= htmlspecialchars($row['patient_name']); ?></strong></td>
                <td><?= date("F j, Y", strtotime($row['appointment_date'])); ?></td>
                <td><?= date("h:i A", strtotime($row['appointment_time'])); ?></td>
                <td class="<?= $statusClass ?>"><?= $row['status']; ?></td>
                <td>
                    <?php if ($row['status'] !== 'Done' && $row['status'] !== 'Cancelled') { ?>
                        <a href="mark_done.php?id=<?= $row['id']; ?>" class="btn done-btn">Mark as Done</a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div id="logoutModal" class="modal-overlay">
    <div class="modal-content">
        <h3 style="margin-top:0;">Confirm Logout</h3>
        <p style="color: #64748b;">Are you sure you want to log out of your dashboard?</p>
        <div class="modal-buttons">
            <button onclick="closeLogoutModal()" class="btn-cancel">Cancel</button>
            <a href="logout.php" class="btn-confirm">Logout Now</a>
        </div>
    </div>
</div>

<script>
    function openLogoutModal(e) {
        e.preventDefault();
        document.getElementById('logoutModal').style.display = 'flex';
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').style.display = 'none';
    }

    // Close if clicking outside the box
    window.onclick = function(event) {
        var modal = document.getElementById('logoutModal');
        if (event.target == modal) {
            closeLogoutModal();
        }
    }
</script>

</body>
</html>
