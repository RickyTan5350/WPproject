<?php
session_start();
include("../db.php");

if ($_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$student = $_SESSION['username'];

$stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
$stmt->bind_param("s", $student);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT hall_id FROM halls WHERE hall_name = ?");
$stmt->bind_param("s", $hall);
$stmt->execute();
$stmt->bind_result($hall_id);
$stmt->fetch();
$stmt->close();

$result = $conn->query("
    SELECT b.*, h.hall_name 
    FROM bookings b 
    JOIN halls h ON b.hall_id = h.hall_id 
    WHERE b.student_id = $user_id 
    ORDER BY b.date DESC
");
include("../templates/header.php");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Booking Status</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            margin: 0;
            padding: 30px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 30px;
        }

        table {
            width: 90%;
            max-width: 1000px;
            margin: auto;
            background: #fff;
            border-collapse: collapse;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 16px;
            text-align: center;
        }

        th {
            background-color: #3a86ff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f8fbff;
        }

        tr:hover {
            background-color: #e0f0ff;
        }

        .btn-back {
            display: block;
            width: fit-content;
            margin: 30px auto 0;
            padding: 10px 20px;
            background-color: #06b6d4;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #0e7490;
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <h2>My Booking Status</h2>

    <table>
        <tr>
            <th>Hall</th>
            <th>Date</th>
            <th>Time From</th>
            <th>Time To</th>
            <th>Purpose</th>
            <th>Status</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['hall_name']) ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['time_from']) ?></td>
                    <td><?= htmlspecialchars($row['time_to']) ?></td>
                    <td><?= htmlspecialchars($row['purpose']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" style="text-align:center;">No bookings found.</td></tr>
        <?php endif; ?>
    </table>

    <a href="../dashboard.php" class="btn-back">Back to Dashboard</a>

</body>
</html>
<?php include("../templates/footer.php"); ?>
