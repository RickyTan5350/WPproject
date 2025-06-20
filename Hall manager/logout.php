<?php
session_start();

// If logout is requested
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// You can put this check to protect this page if needed
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hall Manager Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f2f2f2;
        }
        .logout-form {
            text-align: right;
        }
        .logout-form button {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        .logout-form button:hover {
            background-color: #c0392b;
        }
        .welcome {
            font-size: 24px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="logout-form">
    <form method="post">
        <button type="submit" name="logout">Logout</button>
    </form>
</div>

<div class="welcome">
    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!<br>
    This is your Hall Manager Dashboard.
</div>

<!-- You can add more dashboard content here -->

</body>
</html>
