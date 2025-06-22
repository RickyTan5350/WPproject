<?php
session_start();
include("../db.php");

if ($_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student = $_SESSION['username'];
    $hall = $_POST['hall'];
    $date = $_POST['date'];
    $time_from = $_POST['time_from'];
    $time_to = $_POST['time_to'];
    $purpose = $_POST['purpose'];

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $student);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT hall_id FROM halls WHERE hall_name = ?");
    $stmt->bind_param("s", $hall);
    $stmt->execute();
    $stmt->bind_result($hall_id);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO bookings (student_id, hall_id, date, time_from, time_to, purpose, status) VALUES (?, ?, ?, ?, ?, ?,'Pending')");
    $stmt->bind_param("iissss", $user_id, $hall_id, $date, $time_from, $time_to, $purpose);
    $stmt->execute();

    echo "<script>alert('Booking submitted successfully!'); window.location='view_status.php';</script>";
    exit();
}
?>
<?php include("../templates/header.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Hall</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #ffffff);
            padding: 30px;
            margin: 0;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0d47a1;
        }

        form {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.07);
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            margin-top: 18px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #2196f3;
            outline: none;
            box-shadow: 0 0 5px rgba(33,150,243,0.3);
        }

        input[type="submit"] {
            background-color: #2196f3;
            color: white;
            border: none;
            margin-top: 20px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        input[type="submit"]:hover {
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
    </style>
</head>
<body>

<h2>Book a Hall</h2>

<form method="POST" action="">
    <label for="hall">Hall:</label>
    <select name="hall" id="hall" required>
        <option value="">-- Select a Hall --</option>
        <option value="BK1">Bilik Kuliah 1</option>
        <option value="BK2">Bilik Kuliah 2</option>
        <option value="Kejora Hall">Kejora Hall</option>
        <option value="DSI Hall">DSI Hall</option>
        <option value="SportHall">SportHall</option>
    </select>

    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>

    <label for="time_from">Time From:</label>
    <input type="time" name="time_from" id="time_from" required>

    <label for="time_to">Time To:</label>
    <input type="time" name="time_to" id="time_to" required>

    <label for="purpose">Purpose:</label>
    <textarea name="purpose" id="purpose" rows="4" required></textarea>

    <input type="submit" value="Submit Booking">
</form>

<a href="../dashboard.php" class="btn-back">Back to Dashboard</a>

</body>
</html>
<?php include("../templates/footer.php"); ?>
