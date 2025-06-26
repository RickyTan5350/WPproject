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
        <style>
            body {
                font-family: 'Segoe UI', sans-serif;
                background-color: #f0f4f8;
                margin: 0;
                padding: 20px;
            }

            h2 {
                text-align: center;
                color: #2c3e50;
                margin-bottom: 30px;
            }

            form {
                max-width: 500px;
                margin: 0 auto;
                background: #ffffff;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            }


            form label {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
                color: #333;
            }

            form input[type="text"],
            form input[type="email"],
            form input[type="tel"],
            form input[type="date"],
            form textarea,
            form select {
                width: 100%;
                padding: 10px 14px;
                margin-bottom: 20px;
                border: 1px solid #ccc;
                border-radius: 6px;
                box-sizing: border-box;
                font-size: 14px;
            }

            form input[type="submit"] {
                background-color: #3a86ff;
                color: #fff;
                border: none;
                padding: 12px 20px;
                font-size: 16px;
                border-radius: 8px;
                cursor: pointer;
                transition: 0.3s ease;
            }

            form input[type="submit"]:hover {
                background-color: #265df2;
            }

            table {
                border-collapse: collapse;
                width: 90%;
                margin: 0 auto;
                background: #ffffff;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
            }

            table th, table td {
                border: 1px solid #ddd;
                padding: 12px 15px;
                text-align: center;
            }

            table th {
                background-color: #3a86ff;
                color: #ffffff;
                font-weight: bold;
            }

            table tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            @media (max-width: 600px) {
                form {
                    padding: 20px;
                }

                table {
                    width: 100%;
                    font-size: 14px;
                }
            }

            input::placeholder, textarea::placeholder {
                color: #999; /* light grey */
                opacity: 1;  /* ensure it's visible on all browsers */
                font-style: italic;
            }

            .btn-back {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #3a86ff;
                color: white;
                text-decoration: none;
                border-radius: 8px;
                transition: 0.3s ease;
            }

            .btn-back:hover {
                background-color: #265dbe;
            }
        </style>
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
