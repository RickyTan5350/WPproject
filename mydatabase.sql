-- DROP TABLES IF THEY EXIST
DROP TABLE IF EXISTS audit_log, bookings, profiles, halls, users;

-- USERS TABLE
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student', 'manager') NOT NULL
);

-- PROFILES TABLE
CREATE TABLE profiles (
    profile_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- HALLS TABLE
CREATE TABLE halls (
    hall_id INT AUTO_INCREMENT PRIMARY KEY,
    hall_name VARCHAR(100) NOT NULL,
    location VARCHAR(100),
    capacity INT
);

-- BOOKINGS TABLE
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
);

-- AUDIT LOG TABLE
CREATE TABLE audit_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    manager_id INT NOT NULL,
    action ENUM('Approved', 'Rejected') NOT NULL,
    action_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id),
    FOREIGN KEY (manager_id) REFERENCES users(user_id)
);

-- SAMPLE DATA
INSERT INTO users (username, password, role) VALUES
('admin1', 'admin123', 'admin'),
('student1', 'student123', 'student'),
('manager1', 'manager123', 'manager');

INSERT INTO profiles (user_id, full_name, email, phone) VALUES
(1, 'Admin User', 'admin@example.com', '0123456789'),
(2, 'Student User', 'student@example.com', '0198765432'),
(3, 'Manager User', 'manager@example.com', '0178888888');

INSERT INTO halls (hall_name, location, capacity) VALUES
('BK1', 'Bilik Kuliah 1 N28A', 100),
('BK2', 'Bilik Kuliah 2 N28A', 100),
('Kejora Hall', 'Kejora Hall', 500),
('DSI Hall', 'DSI Complex', 600),
('SportHall', 'Sports Complex', 400);
-- DROP TABLES IF THEY EXIST
DROP TABLE IF EXISTS audit_log, bookings, profiles, halls, users;

-- USERS TABLE
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student', 'manager') NOT NULL
);

-- PROFILES TABLE
CREATE TABLE profiles (
    profile_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- HALLS TABLE
CREATE TABLE halls (
    hall_id INT AUTO_INCREMENT PRIMARY KEY,
    hall_name VARCHAR(100) NOT NULL,
    location VARCHAR(100),
    capacity INT
);

-- BOOKINGS TABLE
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
);

-- AUDIT LOG TABLE
CREATE TABLE audit_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    manager_id INT NOT NULL,
    action ENUM('Approved', 'Rejected') NOT NULL,
    action_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id),
    FOREIGN KEY (manager_id) REFERENCES users(user_id)
);

-- SAMPLE DATA
INSERT INTO users (username, password, role) VALUES
('admin1', 'admin123', 'admin'),
('student1', 'student123', 'student'),
('manager1', 'manager123', 'manager');

INSERT INTO profiles (user_id, full_name, email, phone) VALUES
(1, 'Admin User', 'admin@example.com', '0123456789'),
(2, 'Student User', 'student@example.com', '0198765432'),
(3, 'Manager User', 'manager@example.com', '0178888888');

INSERT INTO halls (hall_name, location, capacity) VALUES
('BK1', 'Block K1', 100),
('MPK1', 'Multipurpose Hall 1', 300),
('Kejora Hall', 'Kejora Building', 500),
('DSI Hall', 'DSI Complex', 600),
('SportHall', 'Sports Complex', 400);
