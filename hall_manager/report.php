<?php
session_start();
include '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'manager') {
    header('Location: ../login.php');
    exit();
}

$order_by = isset($_GET['sort']) && in_array($_GET['sort'], ['date', 'student']) ? $_GET['sort'] : 'date';
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

$stmt = $conn->prepare("
    SELECT b.booking_id, u.username AS student, h.hall_name AS hall, b.date, b.purpose, b.status
    FROM bookings b
    JOIN users u ON b.student_id = u.user_id
    JOIN halls h ON b.hall_id = h.hall_id
    WHERE u.username LIKE ? OR h.hall_name LIKE ?
    ORDER BY $order_by DESC
");
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();
?>
<?php include("../templates/header.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Hall Booking Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #f0f9ff, #ffffff);
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        }

        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 25px;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
            justify-content: center;
        }

        .filter-form input, .filter-form select, .filter-form button {
            padding: 10px 12px;
            font-size: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .filter-form button {
            background-color: #2563eb;
            color: white;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .filter-form button:hover {
            background-color: #1e40af;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background-color: #3b82f6;
            color: white;
            padding: 12px;
            text-align: center;
        }

        tbody td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        tr:nth-child(even) {
            background-color: #f9fbff;
        }

        tr:hover {
            background-color: #ecf3ff;
        }

        .status-badge {
            padding: 6px 10px;
            border-radius: 6px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }

        .status-badge.Approved { background-color: #16a34a; }
        .status-badge.Rejected { background-color: #dc2626; }
        .status-badge.Pending  { background-color: #facc15; color: #333; }

        .btn-back {
            display: block;
            margin: 30px auto 0;
            text-align: center;
            background-color: #06b6d4;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            width: fit-content;
        }

        .btn-back:hover {
            background-color: #0e7490;
        }

        @media (max-width: 768px) {
            .filter-form {
                flex-direction: column;
                align-items: center;
            }

            thead th, tbody td {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Hall Booking Report</h2>
    <form method="GET" class="filter-form">
        <input type="text" name="search" placeholder="Search by student or hall" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <select name="sort">
            <option value="date" <?php if ($order_by == 'date') echo 'selected'; ?>>Sort by Date</option>
            <option value="student" <?php if ($order_by == 'student') echo 'selected'; ?>>Sort by Student</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Hall</th>
                <th>Date</th>
                <th>Purpose</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['booking_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['student']); ?></td>
                    <td><?php echo htmlspecialchars($row['hall']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                    <td>
                        <span class="status-badge <?php echo htmlspecialchars($row['status']); ?>">
                            <?php echo htmlspecialchars($row['status']); ?>
                        </span>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<a href="../dashboard.php" class="btn-back">Back to Dashboard</a>
</body>
</html>
<?php include("../templates/footer.php"); ?>
