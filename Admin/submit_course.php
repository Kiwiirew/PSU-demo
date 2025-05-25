<?php
// Include database connection
include 'db_conn.php';
// Check if form data was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize it to prevent SQL injection
    $courseCode = $conn->real_escape_string($_POST['courseCode']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $department = $conn->real_escape_string($_POST['department']);

    $room = $conn->real_escape_string($_POST['room']);

    // Insert data into the database
    $sql = "INSERT INTO courses (courseCode, subject, department, room) 
            VALUES ('$courseCode', '$subject', '$department', '$room')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to a success page or back to the main page
        header("Location: courses.php?status=success");
        exit();
    } else {
        // Display error message if insertion fails
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
