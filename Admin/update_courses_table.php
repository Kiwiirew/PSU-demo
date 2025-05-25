<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection without database
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS psu_db";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully or already exists<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// Close the connection and reconnect with the database selected
mysqli_close($conn);
$conn = new mysqli($servername, $username, $password, "psu_db");

// Check connection again
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Drop existing tables if they exist
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

$sql = "DROP TABLE IF EXISTS course_instructors";
mysqli_query($conn, $sql);
echo "Dropped course_instructors table (if existed)<br>";

$sql = "DROP TABLE IF EXISTS courses";
mysqli_query($conn, $sql);
echo "Dropped courses table (if existed)<br>";

mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

// Create courses table
$sql = "CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(255) NOT NULL,
    course_tag VARCHAR(50) NOT NULL,
    course_image VARCHAR(255) NOT NULL,
    course_video VARCHAR(255),
    description TEXT NOT NULL,
    career_opportunities TEXT NOT NULL,
    skills_gained TEXT NOT NULL,
    future_impact TEXT NOT NULL,
    duration VARCHAR(50) NOT NULL,
    total_subjects INT NOT NULL,
    level VARCHAR(50) NOT NULL,
    language VARCHAR(50) NOT NULL,
    certificate VARCHAR(10) NOT NULL,
    portal_link VARCHAR(255) NOT NULL DEFAULT 'https://psu362.campus-erp.com/portal/',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!mysqli_query($conn, $sql)) {
    die("Error creating courses table: " . mysqli_error($conn));
}
echo "Courses table created successfully<br>";

// Create instructors table
$sql = "CREATE TABLE course_instructors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    instructor_name VARCHAR(255) NOT NULL,
    designation VARCHAR(100) NOT NULL,
    instructor_image VARCHAR(255) NOT NULL,
    INDEX (course_id),
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!mysqli_query($conn, $sql)) {
    die("Error creating instructors table: " . mysqli_error($conn));
}
echo "Course instructors table created successfully<br>";

echo "Database update completed successfully!";

mysqli_close($conn);
?>
