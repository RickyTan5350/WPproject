<?php
session_start();
include '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'manager') {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE bookings SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $booking_id);
    $stmt->execute();
    $stmt->close();
}

$result = $conn->query("SELECT * FROM bookings WHERE status='Pending'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approve Bookings</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <h2>Pending Hall Booking Requests</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Student</th><th>Hall</th><th>Date</th><th>Purpose</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['student']); ?></td>
                <td><?php echo htmlspecialchars($row['hall']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                <td>
                    <form method="POST" class="inline-form">
                        <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="status" value="Approved">Approve</button>
                        <button type="submit" name="status" value="Rejected">Reject</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
