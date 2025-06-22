
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    role ENUM('admin', 'student', 'manager') NOT NULL
);

INSERT INTO users (username, password, role) VALUES
('admin1', 'admin123', 'admin'),
('manager1', 'mgr123', 'manager'),
('student1', 'stud123', 'student'),
('student2', 'stud456', 'student');
