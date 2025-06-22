<?php
$host = 'localhost';
$user = 'root';       // default user in XAMPP
$pass = '';           // default password in XAMPP is empty
$dbname = 'hall_booking_system';

// Create connection
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Drop existing tables
$conn->query("DROP TABLE IF EXISTS audit_log, bookings, profiles, halls, users");

// Create users table
$conn->query("
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student', 'manager') NOT NULL
)");

// Create profiles table
$conn->query("
CREATE TABLE profiles (
    profile_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
)");

// Create halls table
$conn->query("
CREATE TABLE halls (
    hall_id INT AUTO_INCREMENT PRIMARY KEY,
    hall_name VARCHAR(100) NOT NULL,
    location VARCHAR(100),
    capacity INT
)");

// Create bookings table
$conn->query("
CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    hall_id INT NOT NULL,
    date DATE NOT NULL,
    time_from TIME NOT NULL,
    time_to TIME NOT NULL,
    purpose TEXT,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    FOREIGN KEY (student_id) REFERENCES users(user_id),
    FOREIGN KEY (hall_id) REFERENCES halls(hall_id)
)");

// Create audit_log table
$conn->query("
CREATE TABLE audit_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    manager_id INT NOT NULL,
    action ENUM('Approved', 'Rejected') NOT NULL,
    action_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id),
    FOREIGN KEY (manager_id) REFERENCES users(user_id)
)");

// Insert sample users
$conn->query("
INSERT INTO users (username, password, role) VALUES
('admin1', 'admin123', 'admin'),
('student1', 'student123', 'student'),
('manager1', 'manager123', 'manager')
");

// Insert sample profiles
$conn->query("
INSERT INTO profiles (user_id, full_name, email, phone) VALUES
(1, 'Admin User', 'admin@example.com', '0123456789'),
(2, 'Student User', 'student@example.com', '0198765432'),
(3, 'Manager User', 'manager@example.com', '0178888888')
");

// Insert sample halls
$conn->query("
INSERT INTO halls (hall_name, location, capacity) VALUES
('BK1', 'Block K1', 100),
('MPK1', 'Multipurpose Hall 1', 300),
('Kejora Hall', 'Kejora Building', 500),
('DSI Hall', 'DSI Complex', 600),
('SportHall', 'Sports Complex', 400)
");

echo "Database and tables created, sample data inserted successfully.";

$conn->close();
?>
