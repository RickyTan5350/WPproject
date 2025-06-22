<?php
session_start();

// Access control
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include "../db.php";

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("Invalid user ID.");
}

// Delete user
$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: manage_users.php");
exit;
?>
<?php include("../templates/footer.php"); ?>