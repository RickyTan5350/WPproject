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

    echo "<script>alert('Profile updated!');</script>";
}

// Fetch Profile Info
$result = $conn->query("SELECT * FROM profiles WHERE user_id='$user_id'");
$row = $result->fetch_assoc();

if (!$row) {
    $conn->query("INSERT INTO profiles (user_id, full_name, email, phone) VALUES ('$user_id', '', '', '')");
    // Re-query to get the new profile row
    $result = $conn->query("SELECT * FROM profiles WHERE user_id='$user_id'");
    $row = $result->fetch_assoc();
}

$full_name = $row['full_name'];
$email = $row['email'];
$phone = $row['phone'];?>
<?php include("../templates/header.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Hall Manager Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #e0f2f1, #f5f5f5);
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            color: #00695c;
            margin-bottom: 30px;
        }

        .profile-form label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .profile-form input {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .profile-form input:focus {
            border-color: #26a69a;
            box-shadow: 0 0 5px rgba(38, 166, 154, 0.3);
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #26a69a;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
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
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #01579b;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            .profile-form input {
                font-size: 14px;
            }
        }
    </style>
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

<a href="../dashboard.php" class="btn-back">Back to Dashboard</a>
</body>
</html>
<?php include("../templates/footer.php"); ?>
