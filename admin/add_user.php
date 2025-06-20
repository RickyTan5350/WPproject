<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();

    header("Location: manage_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New User</title>
    <link rel="stylesheet" href="../style.css"> <!-- Correct path from /admin/ -->
</head>
<body>

<h2>Add New User</h2>

<form method="post">
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <select name="role" required>
    <option value="student">Student</option>
    <option value="manager">Hall Manager</option>
    <option value="admin">Admin</option>
  </select>
  <button type="submit">Add User</button>
</form>

</body>
</html>
