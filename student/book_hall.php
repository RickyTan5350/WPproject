<?php
session_start();
include("../db.php");

if ($_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

// Process form when submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student = $_SESSION['username'];
    $hall = $_POST['hall'];
    $date = $_POST['date'];
    $purpose = $_POST['purpose'];

    $stmt = $conn->prepare("INSERT INTO bookings (student, hall, date, purpose, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("ssss", $student, $hall, $date, $purpose);
    $stmt->execute();

    echo "<script>alert('Booking submitted successfully!'); window.location='view_status.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content-width="device-width, initial-scale=1.0">
    <title>Book a Hall</title>
    <link rel="stylesheet" href="studentstyle.css"> <!--remember to change this-->
</head>
<body>

<h2>Book a Hall</h2>

<form method="POST" action="">
    <label>Hall:</label>
    <select name="hall" required>
        <option value="Bilik Kuliah 1">Bilik Kuliah 1</option>
        <option value="Bilik Kuliah 2">Bilik Kuliah 2</option>
        <option value="Bilik Kuliah 3">Bilik Kuliah 3</option>
        <option value="Dewan Kuliah 1">Dewan Kuliah 1</option>
        <option value="Dewan Kuliah 2">Dewan Kuliah 2</option>
    </select><br><br>

    <label>Date:</label>
    <input type="date" name="date" required><br><br>

    <label>Purpose:</label>
    <textarea name="purpose" rows="4" required></textarea><br><br>

    <input type="submit" value="Submit Booking">
</form>

</body>
</html>
