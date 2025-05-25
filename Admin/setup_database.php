<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "psu_db";

// Create connection without database
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Drop database if exists and create new one
$sql = "DROP DATABASE IF EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database dropped successfully<br>";
} else {
    echo "Error dropping database: " . $conn->error . "<br>";
}

$sql = "CREATE DATABASE $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Close connection
$conn->close();

// Connect to the new database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "Courses table created successfully<br>";
} else {
    echo "Error creating courses table: " . $conn->error . "<br>";
}

// Create instructors table
$sql = "CREATE TABLE course_instructors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    instructor_name VARCHAR(255) NOT NULL,
    designation VARCHAR(100) NOT NULL,
    instructor_image VARCHAR(255) NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB";

if ($conn->query($sql) === TRUE) {
    echo "Course instructors table created successfully<br>";
} else {
    echo "Error creating instructors table: " . $conn->error . "<br>";
}

echo "Database setup completed successfully!";

$conn->close();
?>
