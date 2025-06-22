<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../db.php";

$result = $conn->query("SELECT * FROM users");
?>
<?php include("../templates/header.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #ffffff);
            margin: 0;
            padding: 30px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0d47a1;
        }

        .add-btn {
            display: inline-block;
            background-color: #0d6efd;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            transition: background 0.3s;
        }

        .add-btn:hover {
            background-color: #0a58ca;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 18px;
            text-align: center;
        }

        th {
            background-color: #2196f3;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f1f8ff;
        }

        tr:hover {
            background-color: #e3f2fd;
        }

        .action-links a {
            text-decoration: none;
            margin: 0 6px;
            font-weight: 600;
        }

        .action-links a:first-child {
            color: #0288d1;
        }

        .action-links a:last-child {
            color: #d32f2f;
        }

        .action-links a:hover {
            text-decoration: underline;
        }

        .btn-back {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #43a047;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
        }

        .btn-back:hover {
            background-color: #2e7d32;
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            .add-btn, .btn-back {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <h2>Manage Users</h2>

    <a href="add_user.php" class="add-btn">+ Add New User</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['user_id']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td class="action-links">
                <a href="edit_user.php?id=<?= $row['user_id'] ?>">Edit</a> |
                <a href="delete_user.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Delete user?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="../dashboard.php" class="btn-back">Back to Dashboard</a>

</body>
</html>
