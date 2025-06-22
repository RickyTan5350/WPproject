<?php
session_start();
include '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'manager') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE bookings SET status=? WHERE booking_id=?");
    $stmt->bind_param("si", $status, $booking_id);
    $stmt->execute();
    $stmt->close();
}

$result = $conn->query("
    SELECT b.booking_id, u.username AS student, h.hall_name, b.date, b.time_from, b.time_to, b.purpose
    FROM bookings b
    JOIN users u ON b.student_id = u.user_id
    JOIN halls h ON b.hall_id = h.hall_id
    WHERE b.status='Pending'
    ORDER BY b.date DESC
");
?>
<?php include("../templates/header.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Approve Bookings</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #dbeafe, #e0f2fe);
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 14px 18px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #1d4ed8;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0f2fe;
        }

        .inline-form {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        button {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1e40af;
        }

        .btn-back {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #14b8a6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #0f766e;
        }

        @media (max-width: 768px) {
            .inline-form {
                flex-direction: column;
            }

            th, td {
                font-size: 14px;
                padding: 10px;
            }

            button, .btn-back {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pending Hall Booking Requests</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student</th>
                    <th>Hall</th>
                    <th>Date</th>
                    <th>Time From</th>
                    <th>Time To</th>
                    <th>Purpose</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['booking_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['student']); ?></td>
                    <td><?php echo htmlspecialchars($row['hall_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['time_from']); ?></td>
                    <td><?php echo htmlspecialchars($row['time_to']); ?></td>
                    <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                    <td>
                        <form method="POST" class="inline-form">
                            <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                            <button type="submit" name="status" value="Approved">Approve</button>
                            <button type="submit" name="status" value="Rejected">Reject</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="btn-back">Back to Dashboard</a>
    </div>
</body>
</html>
<?php include("../templates/footer.php"); ?>
