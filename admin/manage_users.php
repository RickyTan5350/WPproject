<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../db.php";

$result = $conn->query("SELECT * FROM users");
?>

<h2>Manage Users</h2>
<a href="add_user.php">Add New User</a>
<table border="1">
<tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['username'] ?></td>
    <td><?= $row['role'] ?></td>
    <td>
        <a href="edit_user.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete user?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
