<?php
session_start();
include("../db.php");

if ($_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE profiles SET full_name=?, email=?, phone=? WHERE user_id=?");
    $stmt->bind_param("sssi", $full_name, $email, $phone, $user_id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Profile updated!');</script>";
}

$result = $conn->query("SELECT * FROM profiles WHERE user_id='$user_id'");
$row = $result->fetch_assoc();

// If no profile yet — insert a new empty one
if (!$row) {
    $conn->query("INSERT INTO profiles (user_id, full_name, email, phone) VALUES ('$user_id', '', '', '')");
    // Re-query to get the new profile row
    $result = $conn->query("SELECT * FROM profiles WHERE user_id='$user_id'");
    $row = $result->fetch_assoc();
}

?>

<?php include("../templates/header.php"); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content-width="device-width, initial-scale=1.0">
        <title>Student Profile</title>
        <link rel="stylesheet" href="studentstyle.css"> <!--remember to change this-->
    </head>
    <body>
        <h2>My Profile</h2>
        <form method="POST" action="">
            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo ($row['full_name'] ? $row['full_name'] : ''); ?>" placeholder="Update your full name" required><br><br>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo ($row['email'] ? $row['email'] : ''); ?>" placeholder="Update your email" required><br><br>

            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo ($row['phone'] ? $row['phone'] : ''); ?>" placeholder="Update your phone number" required><br><br>

            <input type="submit" value="Update Profile">
        </form>
    </body>
</html>

<br>
<a href="../dashboard.php" class="btn-back">Back to Dashboard</a>

<?php include("../templates/footer.php"); ?>