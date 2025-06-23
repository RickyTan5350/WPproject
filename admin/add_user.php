<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();

    header("Location: manage_users.php");
    exit;
}
?>
<?php include("../templates/header.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New User</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            padding: 30px;
            margin: 0;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #00796b;
        }

        form {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.07);
        }

        input, select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            border-color: #26a69a;
            outline: none;
            box-shadow: 0 0 5px rgba(38,166,154,0.3);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #26a69a;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #00796b;
        }

        .btn-back {
            display: block;
            width: fit-content;
            margin: 30px auto 0;
            padding: 10px 20px;
            background-color: #0288d1;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #01579b;
        }

        @media (max-width: 600px) {
            form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<h2>Add New User</h2>

<form method="post">
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <select name="role" required>
    <option value="student">Student</option>
    <option value="manager">Hall Manager</option>
    <option value="admin">Admin</option>
  </select>
  <button type="submit">Add User</button>
</form>

<a href="../dashboard.php" class="btn-back">Back to Dashboard</a>

</body>
</html>
<?php include("../templates/footer.php"); ?>