<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../db.php";

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .welcome {
            font-size: 16px;
            font-weight: bold;
        }

        .logout-button {
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <div class="welcome">Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (Admin)</div>
<a href="../logout.php" class="logout-button">Logout</a>
</div>

<h2>Manage Users</h2>
<a href="add_user.php" style="display: inline-block; margin-bottom: 15px; text-decoration: none; color: #007bff;">+ Add New User</a>

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
        <td>
            <a href="edit_user.php?id=<?= $row['user_id'] ?>">Edit</a> |
            <a href="delete_user.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Delete user?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
