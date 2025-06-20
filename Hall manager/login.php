<?php
// hall_manager_login.php

session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['role'] == 'manager') {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            header("Location: manager/hall_dashboard.php");
            exit;
        } else {
            $error = "Access denied. Only Hall Managers can log in here.";
        }
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!-- HTML Login Form goes below PHP -->
<!DOCTYPE html>
<html>
<head>
    <title>Hall Manager Login</title>
    <style>
        body { font-family: Arial; margin: 100px; background: #f4f4f4; }
        form { max-width: 400px; margin: auto; padding: 20px; background: white; box-shadow: 0 0 10px #ccc; }
        input, button { width: 100%; padding: 10px; margin-top: 10px; }
        p { color: red; text-align: center; }
    </style>
</head>
<body>
    <form method="post">
        <h2>Hall Manager Login</h2>
        <input type="text" name="username" required placeholder="Username">
        <input type="password" name="password" required placeholder="Password">
        <button type="submit">Login</button>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </form>
</body>
</html>

