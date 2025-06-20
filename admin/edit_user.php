<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../db.php";

// Validate user ID
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("Invalid ID.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $role = $_POST['role'];

    // Optional: validate role values
    $valid_roles = ['admin', 'manager', 'student'];
    if (!in_array($role, $valid_roles)) {
        die("Invalid role.");
    }

    $stmt = $conn->prepare("UPDATE users SET username = ?, role = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $username, $role, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_users.php");
    exit;
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../style.css"> <!-- assuming style.css is in /WP/ -->
</head>
<body>

<h2>Edit User</h2>

<form method="post">
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required placeholder="Username">
    
    <select name="role" required>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="manager" <?= $user['role'] == 'manager' ? 'selected' : '' ?>>Manager</option>
        <option value="student" <?= $user['role'] == 'student' ? 'selected' : '' ?>>Student</option>
    </select>
    
    <button type="submit">Update</button>
</form>

</body>
</html>
