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
        echo '<link rel="stylesheet" href="assets/dashboard.css">';
    }
    ?>
</head>
<body>
<div style="background:#3a86ff; padding:15px; color:white; text-align:center;">
    <h2>UTM Hall Booking System</h2>
</div>
<div class="container">
