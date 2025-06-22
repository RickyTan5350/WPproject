<?php
session_start();
include '../mydatabase.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'manager') {
    header('Location: ../login.php');
    exit();
}

$order_by = isset($_GET['sort']) && in_array($_GET['sort'], ['date', 'student']) ? $_GET['sort'] : 'date';
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

$stmt = $conn->prepare("SELECT * FROM bookings WHERE student LIKE ? OR hall LIKE ? ORDER BY $order_by");
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hall Booking Report</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <h2>Hall Booking Report</h2>
    <form method="GET" class="filter-form">
        <input type="text" name="search" placeholder="Search by student or hall" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <select name="sort">
            <option value="date" <?php if ($order_by == 'date') echo 'selected'; ?>>Date</option>
            <option value="student" <?php if ($order_by == 'student') echo 'selected'; ?>>Student</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th><th>Student</th><th>Hall</th><th>Date</th><th>Purpose</th><th>Status</th>
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
                <td><?php echo $row['status']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
