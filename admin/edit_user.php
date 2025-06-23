<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../db.php";

// Validate user ID
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("Invalid ID.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $role = $_POST['role'];

    // Optional: validate role values
    $valid_roles = ['admin', 'manager', 'student'];
    if (!in_array($role, $valid_roles)) {
        die("Invalid role.");
    }

    $stmt = $conn->prepare("UPDATE users SET username = ?, role = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $username, $role, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['message'] = "User deleted successfully.";
    header("Location: manage_users.php");
    exit;


    header("Location: manage_users.php");
    exit;
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    die("User not found.");
}
?>
<?php include("../templates/header.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #ffffff);
            margin: 0;
            padding: 30px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0d47a1;
        }

        form {
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        input, select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            border-color: #2196f3;
            box-shadow: 0 0 5px rgba(33,150,243,0.3);
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #2196f3;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #1976d2;
        }

        .btn-back {
            display: block;
            width: fit-content;
            margin: 30px auto 0;
            padding: 10px 20px;
            background-color: #43a047;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #2e7d32;
        }

        @media (max-width: 600px) {
            form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<h2>Edit User</h2>

<form method="post">
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required placeholder="Username">
    
    <select name="role" required>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="manager" <?= $user['role'] == 'manager' ? 'selected' : '' ?>>Manager</option>
        <option value="student" <?= $user['role'] == 'student' ? 'selected' : '' ?>>Student</option>
    </select>
    
    <button type="submit">Update</button>
</form>

<a href="../dashboard.php" class="btn-back">Back to Dashboard</a>

</body>
</html>

<?php include("../templates/footer.php"); ?>