<?php
session_start();
include("../db.php");

if ($_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$student = $_SESSION['username'];
$result = $conn->query("SELECT * FROM bookings WHERE student='$student' ORDER BY date DESC");

include("../templates/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content-width="device-width, initial-scale=1.0">
    <title>My Booking Status</title>
    <link rel="stylesheet" href="studentstyle.css"> <!--remember to change this-->
</head>
<body>

<h2>My Booking Status</h2>

<table border="1" cellpadding="10" cellspacing="0" style="margin:0 auto; background:white; border-collapse:collapse;">
    <tr style="background-color:#3a86ff; color:white;">
        <th>Hall</th>
        <th>Date</th>
        <th>Purpose</th>
        <th>Status</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['hall']."</td>";
            echo "<td>".$row['date']."</td>";
            echo "<td>".$row['purpose']."</td>";
            echo "<td>".$row['status']."</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4' style='text-align:center;'>No bookings found.</td></tr>";
    }
    ?>
</table>

</body>
</html>

<br>
<a href="../dashboard.php" class="btn-back">Back to Dashboard</a>

<?php include("../templates/footer.php"); ?>
