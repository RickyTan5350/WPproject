<?php
session_start();
include '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'manager') {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Update Profile Info
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE profiles SET full_name=?, email=?, phone=? WHERE user_id=?");
    $stmt->bind_param("sssi", $full_name, $email, $phone, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch Profile Info
$stmt = $conn->prepare("SELECT full_name, email, phone FROM profiles WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $phone);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hall Manager Profile</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <h2>Hall Manager Profile</h2>
    <form method="POST" class="profile-form">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

        <button type="submit">Update Profile</button>
    </form>
</div>
</body>
</html>
