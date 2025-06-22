<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}
if (!isset($pageTitle)) {
    $pageTitle = "Hall Booking System";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../assets/style.css">
    <?php
    if (basename($_SERVER['PHP_SELF']) == 'dashboard.php') {
        echo '<link rel="stylesheet" href="dashboard.css">';
    }
    ?>
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #004a99;
            padding: 25px 20px;
            color: white;
            font-family: Arial, sans-serif;
            margin-bottom:15px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
            font-weight: bold;
        }

        .navbar span {
            margin-left: 10px;
            font-weight: bold;
            font-size: 16px
        }

        .navbar-right button {
            background-color: #cc0000;
            border: none;
            padding: 8px 12px;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        .navbar-right button:hover {
            background-color: #990000;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="navbar-left">
        <a href="dashboard.php">Home</a>
        <span>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
    </div>
    <div class="navbar-right">
        <a href="../logout.php"><button>Logout</button></a>
</nav>

</body>